<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Librarian Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('/assets/image/logo.png') }}" width="50" height="50" alt="logo">
            </a>
            <div class="justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <button type="button" class="btn btn-light mx-1 my-2" data-bs-toggle="modal"
                        data-bs-target="#modalRegister">
                        Register
                    </button>
                    <!-- register modal -->
                    <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="registerModal"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('register.borrower') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="registerModal">Register</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label">First Name</label>
                                            <input type="text" name="fname" class="form-control border-dark border"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Last Name</label>
                                            <input type="text" name="lname" class="form-control border-dark border"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Address</label>
                                            <input type="text" name="address" class="form-control border-dark border"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Contact</label>
                                            <input type="text" name="contact" class="form-control border-dark border"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Email</label>
                                            <input type="text" name="email" class="form-control border-dark border"
                                                required />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">ID Picture</label>
                                            <input type="file" name="idpicture" accept=".png, .jpg, .jpeg"
                                                class="form-control border-dark border" required />
                                        </div>
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
                </ul>
            </div>
        </div>
    </nav>


    @if (!empty($search_name))
        <div class="m-4">
            <h2 class="mb-4 text-dark">Result for '{!! $search_name !!}'
                <a class="btn btn-secondary" href="{{ route('index') }}" role="button">Go back</a>
            </h2>

            @if (count($search_items) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-light">
                        <thead class="border border-dark">
                            <tr>
                                <th scope="col" class="border border-dark">#</th>
                                <th scope="col" class="border border-dark">Book No.</th>
                                <th scope="col" class="border border-dark">Book Title</th>
                                <th scope="col" class="border border-dark">Author</th>
                                <th scope="col" class="border border-dark">Publisher</th>
                                <th scope="col" class="border border-dark">Date Published</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $number = 1 @endphp
                            @foreach ($search_items as $search_item)
                                @php
                                    $book_status = '';
                                @endphp
                                <tr>
                                    <td class="border border-dark">{!! $number !!}</td>
                                    <td class="border border-dark">{!! $search_item['catalog_number'] !!}</td>
                                    <td class="border border-dark">{!! $search_item['catalog_book_title'] !!}</td>
                                    <td class="border border-dark">{!! $search_item['catalog_author'] !!}</td>
                                    <td class="border border-dark">{!! $search_item['catalog_publisher'] !!}</td>
                                    <td class="border border-dark">{!! $search_item['catalog_year'] !!}</td>
                                </tr>
                                @php
                                    $number++;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger">
                    No result found
                </div>
            @endif

        </div>
    @else
        <div class="m-4">
            <h2 class="mb-4 text-dark">
                <span class="page-title">List of Books</span>
                <hr>
            </h2>
            
            <div class="col-xl-3 col-lg-3 col-md-6">
                <form action="{{ route('search') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="search_name" class="form-control" placeholder="Search Book"
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                                class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-light">
                    <thead class="border border-dark">
                        <tr>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">#</div>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Book Number</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"number"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "number" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Book Title</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"title"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "title" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Author</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"author"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "author" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Publisher</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"publisher"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "publisher" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Date Published</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"year"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "year" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                            <th scope="col" class="border border-dark">
                                <div class="d-flex justify-content-between">
                                    <div class="text-dark">Status</div>
                                    <a type="button" href="{{ route("index", ['sort_by'=>"year"]) }}" class="float-right">
                                        <i class="{{ Request::get('sort_by') == "year" ? "sort-btn-active" : "sort-btn" }} bi bi-chevron-expand"></i>
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $number = 1 @endphp
                        @foreach ($catalogs as $catalog)
                            @php
                                $book_status = '';
                            @endphp
                            <tr>
                                <td class="border border-dark">{!! $number !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_number'] !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_book_title'] !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_author'] !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_publisher'] !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_year'] !!}</td>
                                <td class="border border-dark">{!! $catalog['catalog_status'] !!}</td>
                            </tr>
                            @php
                                $number++;
                            @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>


</html>
