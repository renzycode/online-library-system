<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\LibrarianModel;
use App\Models\BorrowerModel;
use App\Models\BookModel;
use App\Models\CatalogModel;
use App\Models\TransactionModel;

class PageController extends Controller{
    public function index(Request $request){
        if(!empty($request->search_name)){
            $search_name = $request->search_name;

            $search_items = CatalogModel::where('catalog_book_title','LIKE','%'.$search_name.'%')
                    ->orWhere('catalog_author','LIKE','%'.$search_name.'%')
                    ->get();
        }else{
            $search_name = '';

            $search_items = [];
        }

        $sort_by = "";
        $get_sort_by = $request->sort_by;

        if(empty($request->sort_by) && empty($request->search_name)){
            return redirect(route('index', ['sort_by' => "title"]));
        }

        if($get_sort_by == "title"){
            $sort_by = "catalog_book_title";
        }else if($get_sort_by == "author"){
            $sort_by = "catalog_author";
        }else if($get_sort_by == "number"){
            $sort_by = "catalog_number";
        }else if($get_sort_by == "publisher"){
            $sort_by = "catalog_publisher";
        }else if($get_sort_by == "year"){
            $sort_by = "catalog_year";
        }

        if(!empty($request->search_name)){
            $catalogs = CatalogModel::get();
        }
        else{
            $catalogs = CatalogModel::get()->sortBy($sort_by);
        }
        

        return view('index',['catalogs'=>$catalogs,'search_items'=>$search_items,'search_name' => $search_name]);
    }
    public function search(Request $request){
        $search_name = $request->input('search_name');
        return redirect(route('index', ['search_name' => $search_name]));
    }
    /*
        search
        $result = Marriage::where('name','LIKE','%'.$email_or_name.'%')
                ->orWhere('email','LIKE','%'.$email_or_name.'%')
                ->get();
    */
    
    public function librarianLogin(){
        return view('librarian/login');
    }
    public function sendLogin(Request $request){
        $uname = $request->input('uname');
        $pass = $request->input('pass');
        $uname_is_there = LibrarianModel::where('librarian_uname',$uname)->count();
        if(!($uname_is_there > 0 )){
            return redirect(route('librarian.login',['status'=>'wrong_username']));
        }
        else{
            $pass_fetched_raw = LibrarianModel::where('librarian_uname',$uname)->first(['librarian_pass']);
            $pass_fetched = $pass_fetched_raw['librarian_pass'];
            if(password_verify($pass,$pass_fetched)){
                Session::put('session_librarian_uname',$uname);
                Session::put('session_librarian_status','success');
                return redirect(route('librarian.borrower'));
            }else{
                return redirect(route('librarian.login',['status'=>'wrong_password','uname'=>$uname]));
            }
        }
        return redirect(route('librarian.login'));
    }
    public function sendLogout(){
        Session::flush();
        return redirect(route('librarian.login'));
    }

    //////////////////////////
    ////// DASHBOARD //////////
    //////////////////////////

    public function librarianDashboard(){
        return view('librarian/dashboard');
    }

    //////////////////////////
    ////// DASHBOARD //////////
    //////////////////////////

    //////////////////////////
    ////// BORROWER //////////
    //////////////////////////

    public function librarianBorrower(){
        //authenticate user
        if( Session::has('session_librarian_uname') && Session::has('session_librarian_status') ){
            $uname = Session::get('session_librarian_uname');
            $status = Session::get('session_librarian_status');
            $uname_is_there = LibrarianModel::where('librarian_uname',$uname)->count();
            if($uname_is_there > 0 && $status=='success'){
                $number_of_pending_borrowers = BorrowerModel::where('borrower_status', 'pending')->count();
                $number_of_accepted_borrowers = BorrowerModel::where('borrower_status', 'accepted')->count();
                $number_of_rejected_borrowers = BorrowerModel::where('borrower_status', 'rejected')->count();
                $borrower_numbers = [
                    'pending'=>$number_of_pending_borrowers,
                    'accepted'=>$number_of_accepted_borrowers,
                    'rejected'=>$number_of_rejected_borrowers,
                ];
                $pending_borrowers = BorrowerModel::where('borrower_status', 'pending')->get();
                $accepted_borrowers = BorrowerModel::where('borrower_status', 'accepted')->get();
                $rejected_borrowers = BorrowerModel::where('borrower_status', 'rejected')->get();
                $borrowers = [
                    'pending'=>$pending_borrowers,
                    'accepted'=>$accepted_borrowers,
                    'rejected'=>$rejected_borrowers,
                ];
                return view('librarian/borrower',['borrower_numbers'=>$borrower_numbers,'borrowers'=>$borrowers]);
            }
        }
        Session::flush();
        return redirect( route('librarian.login') );
    }

    public function registerBorrower(Request $request){
        $filename=$_FILES["idpicture"]["name"];
        $tempname=$_FILES["idpicture"]["tmp_name"];
        $folder='assets/image/idpictures/'.$filename;

        $create_borrower = BorrowerModel::create([
            'borrower_fname' => $request-> fname,
            'borrower_lname' => $request-> lname,
            'borrower_address' => $request-> address,
            'borrower_contact' => $request-> contact,
            'borrower_email' => $request-> email,
            'borrower_id_image_name' => $filename,
            'borrower_status' => 'pending',
        ]);
        if(move_uploaded_file($tempname,$folder)){
            $create_borrower->save();
            return redirect(route('index'));
        }
        return redirect(route('index',['error'=>'uploadpicture']));
    }

    public function rejectBorrower(Request $request){
        BorrowerModel::where('borrower_id',$request->id)->update(['borrower_status'=>'rejected']);
        return redirect(route('librarian.borrower'));
    }
    public function deleteRejectedBorrower(Request $request){
        BorrowerModel::where('borrower_id',$request->id)->delete();
        return redirect(route('librarian.borrower',['group'=>'rejected']));
    }
    public function acceptBorrower(Request $request){
        BorrowerModel::where('borrower_id',$request->id)->update(['borrower_status'=>'accepted']);
        return redirect(route('librarian.borrower'));
    }
    public function deleteAllRejectedBorrower(Request $request){
        BorrowerModel::where('borrower_status','rejected')->delete();
        return redirect(route('librarian.borrower',['group'=>'rejected']));
    }

    //////////////////////////
    ////// END BORROWER //////
    //////////////////////////

    //////////////////////////
    ////// BOOK //////////////
    //////////////////////////
    /*
    public function librarianBook(){
        //authenticate user
        if( Session::has('session_librarian_uname') && Session::has('session_librarian_status') ){
            $uname = Session::get('session_librarian_uname');
            $status = Session::get('session_librarian_status');
            $uname_is_there = LibrarianModel::where('librarian_uname',$uname)->count();
            if($uname_is_there > 0 && $status=='success'){
                $books = BookModel::get();
                $catalogs = CatalogModel::get();
                return view('librarian/book',['books'=>$books,'catalogs'=>$catalogs]);
            }
        }
        Session::flush();
        return redirect( route('librarian.login') );
    }
    public function deleteBook(Request $request){
        BookModel::where('book_id', $request->book_id)->delete();
        return redirect(route('librarian.book'));
    }
    public function editBook(Request $request){
        BookModel::where('catalog_id', $request->catalog_id)->update([
            'book_status' => $request->book_status,
        ]);
        return redirect(route('librarian.book'));
    }
    */
    //////////////////////////
    ////// END BOOK ///////
    //////////////////////////




    //////////////////////////
    ////// CATALOG ///////////
    //////////////////////////

    public function librarianCatalog(){
        //authenticate user
        if( Session::has('session_librarian_uname') && Session::has('session_librarian_status') ){
            $uname = Session::get('session_librarian_uname');
            $status = Session::get('session_librarian_status');
            $uname_is_there = LibrarianModel::where('librarian_uname',$uname)->count();
            $librarian_raw = LibrarianModel::where('librarian_uname',$uname)->first();
            $librarian_id = $librarian_raw['librarian_id'];
            if($uname_is_there > 0 && $status=='success'){
                $catalogs = CatalogModel::get();
                return view('librarian/catalog',['catalogs'=>$catalogs,'librarian_id'=>$librarian_id]);
            }
        }
        Session::flush();
        return redirect( route('librarian.catalog') );
    }
    public function addCatalog(Request $request){
        $create_catalog = CatalogModel::create([
            'librarian_id' => $request-> librarian_id,
            'catalog_number' => $request-> catalog_number,
            'catalog_book_title' => $request-> catalog_book_title,
            'catalog_author' => $request-> catalog_author,
            'catalog_publisher' => $request-> catalog_publisher,
            'catalog_year' => $request-> catalog_year,
            'catalog_date_received' => $request-> catalog_date_received,
            'catalog_class' => $request-> catalog_class,
            'catalog_edition' => $request-> catalog_edition,
            'catalog_volumes' => $request-> catalog_volumes,
            'catalog_pages' => $request-> catalog_pages,
            'catalog_source_of_fund' => $request-> catalog_source_of_fund,
            'catalog_cost_price' => $request-> catalog_cost_price,
            'catalog_location_symbol' => $request-> catalog_location_symbol,
            'catalog_class_number' => $request-> catalog_class_number,
            'catalog_author_number' => $request-> catalog_author_number,
            'catalog_copyright_date' => $request-> catalog_copyright_date,
            'catalog_status' => $request-> catalog_status,
        ]);
        $create_catalog->save();
        $catalogs = CatalogModel::get();
        $highest_id_value = 0;
        foreach($catalogs as $catalog){
            if($highest_id_value < intval($catalog['catalog_id'])){
                $highest_id_value = $catalog['catalog_id'];
            }
        }
        /*
        $create_book = BookModel::create([
            'catalog_id'=> intval($highest_id_value),
            'book_status'=>'available'
        ]);
        $create_book->save();
        */
        return redirect(route('librarian.catalog'));
    }
    public function deleteCatalog(Request $request){
        /*
        BookModel::where('catalog_id', $request->catalog_id)->delete();
        */

        CatalogModel::where('catalog_id', $request->catalog_id)->delete();
        return redirect(route('librarian.catalog'));
    }
    public function editCatalog(Request $request){
        CatalogModel::where('catalog_id', $request->catalog_id)->update([
            'catalog_number' => $request-> catalog_number,
            'catalog_book_title' => $request-> catalog_book_title,
            'catalog_author' => $request-> catalog_author,
            'catalog_publisher' => $request-> catalog_publisher,
            'catalog_year' => $request-> catalog_year,
            'catalog_date_received' => $request-> catalog_date_received,
            'catalog_class' => $request-> catalog_class,
            'catalog_edition' => $request-> catalog_edition,
            'catalog_volumes' => $request-> catalog_volumes,
            'catalog_pages' => $request-> catalog_pages,
            'catalog_source_of_fund' => $request-> catalog_source_of_fund,
            'catalog_cost_price' => $request-> catalog_cost_price,
            'catalog_location_symbol' => $request-> catalog_location_symbol,
            'catalog_class_number' => $request-> catalog_class_number,
            'catalog_author_number' => $request-> catalog_author_number,
            'catalog_copyright_date' => $request-> catalog_copyright_date,
            'catalog_status' => $request-> catalog_status,
        ]);
        return redirect(route('librarian.catalog'));
    }

    //////////////////////////
    ////// END CATALOG ///////
    //////////////////////////




    //////////////////////////
    ////// TRANSACTION ///////
    //////////////////////////

    public function librarianTransaction(){
        //authenticate user
        if( Session::has('session_librarian_uname') && Session::has('session_librarian_status') ){
            $uname = Session::get('session_librarian_uname');
            $status = Session::get('session_librarian_status');
            $uname_is_there = LibrarianModel::where('librarian_uname',$uname)->count();
            $librarian_raw = LibrarianModel::where('librarian_uname',$uname)->first();
            $librarian_id = $librarian_raw['librarian_id'];
            if($uname_is_there > 0 && $status=='success'){
                $transactions = TransactionModel::get();
                return view('librarian/transaction',['transactions'=>$transactions]);
            }
        }
        Session::flush();
        return redirect( route('librarian.catalog') );
    }
}