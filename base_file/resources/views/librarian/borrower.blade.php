@extends('librarian/template')

@php

$group = "";
$title = "";

if(!isset($_GET['group'])){
    $redirect = route('librarian.borrower', ['group' => 'pending']);
    echo '<script> window.location.href = "'.$redirect.'"; </script>';
}else{
    $group = $_GET['group'];
}

@endphp

@section('navigation-active')
    @php
        $active = 'borrower';
    @endphp
@endsection

@section('content')
    <div class="m-4">
        <h2 class="mb-4 text-dark">
            <span class="page-title">
            @php 
                if($group=="pending")
                    echo "Pending";
                if($group=="accepted")
                    echo "Accepted";
                if($group=="rejected")
                    echo "Rejected";
            @endphp 
            Borrowers
            </span>
            <br>
            <hr>
            <a href="{{ route('librarian.borrower', ['group' => 'pending']) }}" type="button" 
                @if($group == "pending")
                    class="btn text-light btn-dark ml-1"
                @else
                    class="btn text-light btn-secondary ml-1"
                @endif
                >
                Pending
            </a>
            <a href="{{ route('librarian.borrower', ['group' => 'accepted']) }}" type="button" 
                @if($group == "accepted")
                    class="btn text-light btn-dark ml-1"
                @else
                    class="btn text-light btn-secondary ml-1"
                @endif
                >
                Accepted
            </a>
            <a href="{{ route('librarian.borrower', ['group' => 'rejected']) }}" type="button" 
                @if($group == "rejected")
                    class="btn text-light btn-dark ml-1"
                @else
                    class="btn text-light btn-secondary ml-1"
                @endif
                >
                Rejected
            </a>   
            
                @if($group == "accepted")

                    <!-- view button if accepted section -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="">
                        Download Report (Accepted Borrowers)
                    </button>

                @elseif($group == "rejected")

                    <!-- view button if rejected section -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-all-rejected">
                        Delete All
                    </button>

                    <!-- delete all modal -->
                    <div class="modal fade" id="delete-all-rejected" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('delete.all.rejected.borrower') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete All Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete all data?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end delete all modal -->

                @endif
        </h2>
        
        <!-- pending borrowers -->
        @if($group=='pending')
            @if ( count($borrowers['pending'])<=0 )
                <div class="alert alert-warning">
                    No pending borrowers to be displayed
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Accept</th>
                                <th scope="col">Reject</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        @php
                            $number = 0;
                        @endphp
                            @foreach ($borrowers['pending'] as $data)
                                @php
                                    $number++;
                                @endphp
                                <tr>
                                    <td>{!!$number!!}</td>
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView{!!$number!!}">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{!!$data['borrower_fname']!!}'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="300">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>{!!$data['borrower_id']!!}</td>
                                    <td>{!!$data['borrower_fname']!!}</td>
                                    <td>{!!$data['borrower_lname']!!}</td>
                                    <td>{!!$data['borrower_address']!!}</td>
                                    <td>{!!$data['borrower_contact']!!}</td>
                                    <td>{!!$data['borrower_email']!!}</td>
                                    
                                    <td>
                                        <!-- accept modal button-->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAccept{!!$number!!}">
                                            <i class="bi-check-circle"></i>
                                        </button>
                                        <!-- accept modal -->
                                        <div class="modal fade" id="modalAccept{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('accept.borrower') }}" method="post">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Accept Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to accept this borrower?
                                                            <input type="hidden" name="id" value="{!!$data['borrower_id']!!}">
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Yes</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end accept modal -->
                                    </td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject{!!$number!!}">
                                            <i class="bi-x-circle"></i>
                                        </button>
                                        <!-- reject modal -->
                                        <div class="modal fade" id="modalReject{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('reject.borrower') }}" method="post">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reject Borrower</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to reject this borrower?
                                                            <input type="hidden" name="id" value="{!!$data['borrower_id']!!}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end reject modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        <!-- end pending borrowers -->

        <!-- accepted borrowers -->
        @if($group=='accepted')
            @if ( count($borrowers['accepted'])<=0 )
                <div class="alert alert-warning">
                    No accepted borrowers to be displayed
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="border">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody class="border">
                        @php
                            $number = 0;
                        @endphp
                            @foreach ($borrowers['accepted'] as $data)
                                @php
                                    $number++;
                                @endphp
                                <tr>
                                    <td>{!!$number!!}</td>
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView{!!$number!!}">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{!!$data['borrower_fname']!!}'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="300">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>{!!$data['borrower_id']!!}</td>
                                    <td>{!!$data['borrower_fname']!!}</td>
                                    <td>{!!$data['borrower_lname']!!}</td>
                                    <td>{!!$data['borrower_address']!!}</td>
                                    <td>{!!$data['borrower_contact']!!}</td>
                                    <td>{!!$data['borrower_email']!!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        <!-- end accepted borrowers -->

        <!-- rejected borrowers -->
        @if($group=='rejected')
            @if ( count($borrowers['rejected'])<=0 )
                <div class="alert alert-warning">
                    No rejecetd borrowers to be displayed
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" id="example">
                        <thead class="table-bordered">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Id Picture</th>
                                <th scope="col">Borrower Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="table-bordered">
                        @php
                            $number = 0;
                        @endphp
                            @foreach ($borrowers['rejected'] as $data)
                                @php
                                    $number++;
                                @endphp
                                <tr>
                                    <td>{!!$number!!}</td>
                                    <td>
                                        <button type="button" class="btn p-0 rounded border border-secondary" data-bs-toggle="modal" data-bs-target="#modalView{!!$number!!}">
                                            <!--i class="bi-eye"></i--> 
                                            <img class="p-0 rounded" src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="40" height="40">
                                        </button>
                                        <!-- view pic modal -->
                                        <div class="modal fade" id="modalView{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{!!$data['borrower_fname']!!}'s ID Picture</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center m-2">
                                                        <img src="{{ asset('assets/image/idpictures/'.$data['borrower_id_image_name']) }}" width="300">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end view pic modal -->
                                    </td>
                                    <td>{!!$data['borrower_id']!!}</td>
                                    <td>{!!$data['borrower_fname']!!}</td>
                                    <td>{!!$data['borrower_lname']!!}</td>
                                    <td>{!!$data['borrower_address']!!}</td>
                                    <td>{!!$data['borrower_contact']!!}</td>
                                    <td>{!!$data['borrower_email']!!}</td>
                                    <td>
                                        <!-- reject modal button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalReject{!!$number!!}">
                                            <i class="bi-trash"></i>
                                        </button>
                                        <!-- delete modal -->
                                        <div class="modal fade" id="modalReject{!!$number!!}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('delete.rejected.borrower') }}" method="post">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this data?
                                                            <input type="hidden" name="id" value="{!!$data['borrower_id']!!}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Yes</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end delete modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
        <!-- end rejected borrowers -->

    </div>

@endsection
