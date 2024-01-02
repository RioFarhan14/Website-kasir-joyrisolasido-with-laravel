@extends('layout.main')
@section('content-asset')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
@endsection
@section('content')
<div class="content-inventory p-4">
  <!-- Content Row -->
  <div class="row">
    <div class="col-12">
      <h4 class="text-secondary">Inventori</h4>
      <a role="button" href="{{ route('kategori') }}"
        class="light-green py-2 px-4 rounded not-border font-weight-600 text-decoration-none text-dark">
        Tambah kategori
      </a>
      <a role="button" href="{{ route('produk') }}"
        class="light-green py-2 px-4 mx-2 rounded not-border font-weight-600 text-decoration-none text-dark">
        Tambah produk
      </a>
      <div class="row">
        <div class="col-12 my-3">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-secondary">
                Kategori
              </h6>
            </div>
            <div class="card-body">
              <table id="table-category" class="table table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama kategori</th>
                    <th>gambar</th>
                    <th>aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kategori as $item)
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                      <img class="cat-img" src="{{ asset('storage/category/'. $item->gambar) }}" alt="" />
                    </td>
                    <td>
                      <div class="d-flex flex-row align-items-center">
                        <a href="{{ route('kategori.edit', $item->id) }}"
                          class="btn bg-warning rounded p-1 px-3 not-border mx-2">edit</a>
                        <a class="btn bg-danger rounded p-1 px-3 not-border" href="#deletecategory{{ $item->id }}"
                          data-toggle="modal" href="">hapus</a>
                        @include('crud_category.action')
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-secondary">
                Produk
              </h6>
            </div>
            <div class="card-body">
              <table id="table-product" class="table table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($produk as $item)
                  <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->category->nama }}</td>
                    <td>Rp. {{ number_format($item->harga, 0, 2) }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                      <div class="d-flex flex-row align-items-center">
                        <a class="btn bg-warning rounded p-1 px-3 not-border mx-2"
                          href="{{ route('produk.edit', $item->id) }}">edit</a>
                        <a class="btn bg-danger rounded p-1 px-3 not-border" data-toggle="modal"
                          href="#deleteproduct{{ $item->id }}">hapus</a>
                        @include('crud_product.action')
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection