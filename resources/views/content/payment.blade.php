@extends('layout.main')
@section('content-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content-asset')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- Load Bootstrap CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
<script src="{{ asset('js/payment.js') }}"></script>
<script src="{{ asset('js/show-product-payment.js') }}"></script>
<script src="{{ asset('js/checkout.js') }}"></script>
@endsection
@section('content')
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-8">
      <div class="col-12">
        <h4 class="text-secondary">Kategori</h4>
        <div class="category">
          @foreach ($category as $item)
          <button
            class="category-button col-3 btn-light d-flex flex-column align-items-center rounded-card p-3 not-border shadow mx-2"
            data-category-id="{{ $item->id }}">
            <img class=" cat-img" src="{{ asset('storage/category/'. $item->gambar) }}" alt="" />
            @if (strlen($item->nama) > 20)
            <small>{{ $item->nama }}</small>
            @else
            <span>{{ $item->nama }}</span>
            @endif
          </button>
          @endforeach
        </div>
      </div>
      <div class="product">
        <div class="col-12">
          <div class="row" id="products-container">
          </div>
        </div>
      </div>
    </div>
    <div class="col-4 bg-white shadow rounded-card p-4 d-flex flex-column justify-content-between align-items-center">

      <!-- Judul Pembayaran -->
      <p class="text-uppercase font-weight-bold">Pembayaran</p>

      <!-- Konten Produk -->
      <div class="menu-checkout" id="list-checkout">

      </div>
      <!-- Tombol Metode Pembayaran -->
      <div class="row">
        <button id="debitbutton" class="debitbutton">Debit</button>
        <button id="tunaibutton" class="tunaibutton">Tunai</button>
      </div>

      <!-- Tombol Bayar -->
      <div class="row my-2 button-buy">
        <button type="button" data-toggle="modal" id="bayarButton">Bayar</button>
      </div>
    </div>
  </div>

  <!-- modal success-->
  <div class="modal fade" id="success_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content p-4 rounded-card">
        <!-- Menambahkan padding sebesar 4 -->
        <div class="modal-body">
          <div class="container d-flex flex-column align-items-center">
            <span class="rounded-circle p-3 badge-success"><i class="fa-solid fa-check fa-5x"></i></span>
            <h4 class="pt-3 text-dark">Pembayaran Cash Berhasil</h4>
            <div class="line my-3"></div>
            <div class="container my-4 d-flex flex-row justify-content-around">
              <button class="btn btn-form-customer p-1">Cetak Invoice</button>
              <button class="btn btn-form-customer">OK</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection