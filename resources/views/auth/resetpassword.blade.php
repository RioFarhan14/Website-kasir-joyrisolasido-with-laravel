@extends('layout.main')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-7 d-flex flex-column bg-white rounded-card p-4 m-4">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form action="{{ route('auth.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="name">Password lama</label>
                    <input type="text" value="{{ old('old_password') }}" name="old_password"
                        class="form-control bg-light col-9 @error('old_password') is-invalid @enderror" required
                        placeholder="*Masukan password lama anda">
                </div>
                @error('old-password')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="name">Password baru</label>
                    <input type="text" value="{{ old('new_password') }}" name="new_password"
                        class="form-control bg-light col-9 @error('new_password') is-invalid @enderror"
                        placeholder="*Masukan password baru yang anda inginkan">
                </div>
                @error('new-password')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex justify-content-end my-4">
                    <button class="btn-input shadow text-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection