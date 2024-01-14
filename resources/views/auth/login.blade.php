<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/joyrisolasido.jpeg') }}">
    <title>Joyrisolasido</title>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" />
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-primary text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                            @endif
                            <form action="{{ route('login.authenticate') }}" method="post">
                                @csrf
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control form-control-lg" />
                                    @error('email')
                                    <small class="text-danger mx-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg" />
                                    @error('password')
                                    <small class="text-danger mx-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>