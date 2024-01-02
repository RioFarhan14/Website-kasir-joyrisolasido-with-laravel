@extends('layout.main')
@section('content-asset')
<script src="{{ asset('js/input-img.js') }}"></script>
@endsection
@section('content')
<div class="content-inventory">
    <div class="col-3">
        <h3 style="text-align: center;">TAMBAH BARANG</h3>
        <hr class=" bg-dark">
    </div>
    <div class="row">
        <div class="col-7 d-flex flex-column bg-white rounded-card p-4 mx-4">
            <form action="{{ route('produk.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="name">Nama Produk</label>
                    <input type="text" id="name" name="nama"
                        class="form-control bg-light col-9 @error('nama') is-invalid @enderror" required
                        placeholder="*masukan nama produk yang diinginkan" value="{{ old('nama') }}">
                </div>
                @error('nama')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="harga-produk">Kategori Produk</label>
                    <select name="kategori_id" id="nama-kategori"
                        class="form-control bg-light col-9 @error('kategori_id') is-invalid @enderror">
                        <option class="text-muted" value="" selected disabled>*pilih kategori yang diinginkan</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id')==$item->id ? 'selected' : '' }}>{{
                            $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                @error('kategori_id')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="harga-produk">Harga Produk</label>
                    <input type="text" value="{{ old('harga') }}" name="harga"
                        class="form-control bg-light col-9  @error('harga') is-invalid @enderror"
                        placeholder="*masukan harga produk yang diinginkan" required>
                </div>
                @error('harga')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="stok">Stok</label>
                    <input type="text" name="stok" value="{{ old('stok') }}"
                        class="form-control bg-light col-9 @error('stok') is-invalid @enderror"
                        placeholder="*masukan stok yang diinginkan" required>
                </div>
                @error('stok')
                <small class="text-danger mx-2">{{ $message }}</small>
                @enderror
                <div class="col-12 d-flex flex-row justify-content-between my-4">
                    <label for="gambar">Gambar</label>
                    <div class="col-9">
                        <img id="preview-image" src="{{ asset('img/no-picture.png') }}" class="input-img" alt="">
                        <input type="file" name="gambar" id="gambar-input" accept=".jpg, .jpeg, .png., .webp" required>
                        @error('gambar')
                        <div class="col-12">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn-input shadow text-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection