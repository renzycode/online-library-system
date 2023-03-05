<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Librarian Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/dataTables/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/dataTables/dataTables.bootstrap5.min.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('/assets/image/logo.png') }}" width="50" height="50" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <a href="{{ route('librarian.borrower') }}" class="btn btn-secondary mx-1 my-2" type="button">Borrower</a>
                    <a href="{{ route('librarian.transaction') }}" class="btn btn-secondary mx-1 my-2" type="button">Transaction</a>
                    <a href="{{ route('librarian.catalog') }}" class="btn btn-secondary mx-1 my-2" type="button">Catalog</a>
                    <button type="button" class="btn mx-1 my-2 p-1" data-bs-toggle="modal"
                        data-bs-target="#modalLogout">
                        <i class="bi-box-arrow-right text-light"></i>
                    </button>
                    <!-- logout modal -->
                    <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to logout?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('send.logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Yes</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end logout modal -->
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/dataTables/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/dataTables/dataTables.bootstrap5.min.js') }}"></script>
    

    <script>
        $(document).ready(function () {
            $('.myDataTable').DataTable();
        });
    </script>

</body>


</html>