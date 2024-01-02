@extends('layout.main')
@section('content-asset')
<script src="{{ asset('js/input-img.js') }}"></script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="col-3">
        <h3 style="text-align: center;">TAMBAH KATEGORI</h3>
        <hr class=" bg-dark">
    </div>
    <div class="row">
        <div class="col-7 d-flex flex-column bg-white rounded-card p-4 m-4">
            <form action="{{ route('kategori.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="name">Nama Kategori</label>
                    <input type="text" value="{{ old('nama') ? old('nama') : $category->nama }}" name="nama"
                        class="form-control bg-light col-9 @error('nama') is-invalid @enderror" required
                        placeholder="*masukan nama kategori yang diinginkan">
                </div>
                @error('nama')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="gambar">Gambar</label>
                    <div class="col-9">
                        <img id="preview-image" src="{{ asset('storage/category/'. $category->gambar) }}"
                            class="input-img @error('gambar') is-invalid @enderror" alt="">
                        <input type="file" name="gambar" id="gambar-input" accept=".jpg, .jpeg, .png., .webp">
                        @error('gambar')
                        <div class="col-12">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end my-4">
                    <button class="btn-input shadow text-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection