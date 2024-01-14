<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow d-flex justify-content-end">
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('auth.edit') }}">Ubah password</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="dropdown-item" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>