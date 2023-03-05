@extends('librarian/template')

@section('content')
<div class="m-4">
    <h2 class="mb-4 text-dark">Book
    </h2>
    <!-- add modal -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('add.book') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bookNumber" class="col-form-label">Book Number</label>
                            <input type="text" name="book_number" class="form-control border-dark border" />
                        </div>
                        <div class="form-group">
                            <label for="bookTitle" class="col-form-label">Book Title</label>
                            <input type="text" name="book_title" class="form-control border-dark border" />
                            <div class="form-group">
                                <label for="author" class="col-form-label">Author</label>
                                <input type="text" name="book_author" class="form-control border-dark border" />
                            </div>
                            <div class="form-group">
                                <label for="publisher" class="col-form-label">Publisher</label>
                                <input type="text" name="book_publisher" class="form-control border-dark border" />
                            </div>
                            <div class="form-group">
                                <label for="datePublished" class="col-form-label">Date Published</label>
                                <input type="text" name="book_date_published" class="form-control border-dark border" />
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-form-label">Status</label>
                                <select name="book_status" class="form-control form-select border-dark border"
                                    aria-label="status">
                                    <option value="available" selected>Available</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end add modal -->
    @if ( count($books)<=0 )
    <div class="alert alert-warning">
        No books to be displayed
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-light">
            <thead class="border border-dark">
                <tr>
                    <th scope="col" class="border border-dark">#</th>
                    <th scope="col" class="border border-dark">Book Number</th>
                    <th scope="col" class="border border-dark">Book Title</th>
                    <th scope="col" class="border border-dark">Author</th>
                    <th scope="col" class="border border-dark">Publisher</th>
                    <th scope="col" class="border border-dark">Date Published</th>
                    <th scope="col" class="border border-dark">Status</th>
                    <th scope="col" class="border border-dark">Edit</th>
                </tr>
            </thead>
            <tbody>
                @php $number = 1 @endphp
                @foreach ($catalogs as $catalog)
                    @php
                        $book_status = '';
                    @endphp
                    <tr>
                        <td class="border border-dark">{!!$number!!}</td>
                        <td class="border border-dark">{!!$catalog['catalog_number']!!}</td>
                        <td class="border border-dark">{!!$catalog['catalog_book_title']!!}</td>
                        <td class="border border-dark">{!!$catalog['catalog_author']!!}</td>
                        <td class="border border-dark">{!!$catalog['catalog_publisher']!!}</td>
                        <td class="border border-dark">{!!$catalog['catalog_year']!!}</td>
                        @foreach ($books as $book)
                            @php
                                if($book['catalog_id']==$catalog['catalog_id']){
                                    $book_status = $book['book_status'];
                                }
                            @endphp
                        @endforeach
                        @if($book_status=='available')
                        <td class="border border-dark"> Available <i class="bi-check text-success"></i> </td>
                        @elseif($book_status=='unavailable')
                        <td class="border border-dark"> Unavailable <i class="bi-x text-danger"></i> </td>
                        @endif
                        <td class="border border-dark">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{!!$number!!}">
                                <i class="bi-pencil-square"></i>
                            </button>

                            <!-- edit modal -->
                            <div class="modal fade" id="modalEdit{!!$number!!}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('edit.book') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Book</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="catalog_id" value="{!! $catalog['catalog_id'] !!}">
                                                <p>No. {!! $catalog['catalog_number'] !!} </p>
                                                @if($book_status=='available')
                                                    <div class="form-group">
                                                        <label for="status" class="col-form-label">Status</label>
                                                        <select name="book_status" class="form-control form-select border-dark border"
                                                            aria-label="status">
                                                            <option value="available" selected>Available</option>
                                                            <option value="unavailable">Unavailable</option>
                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="status" class="col-form-label">Status</label>
                                                        <select name="book_status" class="form-control form-select border-dark border"
                                                            aria-label="status">
                                                            <option value="unavailable" selected>Unavailable</option>
                                                            <option value="available">Available</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end edit modal -->
                        </td>
                    </tr>
                    @php
                        $number++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection