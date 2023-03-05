
@if(isset($_GET['uname']))
    @php $uname = $_GET['uname']; @endphp
@else
    @php $uname = ''; @endphp
@endif

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Librarian Panel</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
</head>

<body>
    <div class="d-flex justify-content-center">
        <form action="{{ route('send.login') }}" class="row mt-5 shadow" method="post">
            @csrf
            <div class="col-12 border bg-dark border-1 border-dark">
                <h4 class="text-light mt-2">Librarian Login Form</h4>
            </div>
            <div class="col-12 border border-1 border-dark">
                <div class="my-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control border border-dark" name="uname" value="{!!$uname!!}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control border border-dark" name="pass" required>
                </div>
                @if(isset($_GET['status']))
                    @php $status = $_GET['status']; @endphp
                    @if($status=='error')
                        <div class="mb-3">
                            <p class="alert alert-danger m-0 p-2">Error, Please try again later.</p>
                        </div>
                    @elseif($status=='wrong_username')
                        <div class="mb-3">
                            <p class="alert alert-danger m-0 p-2">Wrong Username</p>
                        </div>
                    @elseif($status=='wrong_password')
                        <div class="mb-3">
                            <p class="alert alert-danger m-0 p-2">Wrong Password</p>
                        </div>
                    @endif
                @endif
                <div class="mb-3">
                    <button class="btn btn-dark" type="submit">Log in</button>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>


</html>