@extends('layout.main')
@section('content-asset')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/report.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
@endsection
@section('content')
<div class="content-inventory p-4">
  <!-- Content Row -->
  <div class="row">
    <div class="col-xl-6 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Pencapaian Penjualan Tiap Bulan</h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered" id="table-pencapaian" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Bulan</th>
                <th>Total Transaksi</th>
                <th>Total Pendapatan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($salesData as $data)
              <tr>
                <td>{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}
                </td>
                <!-- Anda perlu mengganti placeholder ini dengan data yang sesuai dari controller -->
                <td>{{ $data->total_transaksi }}</td>
                <!-- Jika Anda memiliki data pendapatan, Anda bisa menambahkan kolom ini -->
                <td>Rp. {{ number_format($data->total_harga, 0, 2) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="col-xl-6 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Produk terlaris</h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered" id="table-terlaris" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah yang terjual</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bestSellingProducts as $product)
              <tr>
                <td>{{ $product->product->nama }}</td>
                <td>Rp. {{ number_format($product->product->harga, 0, 2) }}</td>
                <td>{{ $product->total_sold }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">Riwayat Transaksi</h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered" id="table-transaksi" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Total Pembelian</th>
                <th>Tanggal Pembelian</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($transactions as $transaction)
              <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->customer->nama }}</td>
                <td>Rp. {{ number_format( $transaction->total_harga, 0, 2) }}</td>
                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                <td>
                  <div class="d-flex flex-row align-items-center">
                    <button data-invoice-id="{{ $transaction->id }}"
                      class="showinvoice bg-primary text-white rounded p-1 px-3 not-border mx-2">Info</button>
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
@endsection