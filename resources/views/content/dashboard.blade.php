@extends('layout.main')
@section('content')
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card shadow rounded-card h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                Pendapatan Bulan ini
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}
              </div>
            </div>
            <div class="col-auto rounded-circle softgreen">
              <i class="fas fa-sack-dollar fa-2x text-success p-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card shadow rounded-card h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                Transaksi Bulan ini
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalTransactionsThisMonth }}
              </div>
            </div>
            <div class="col-auto rounded-circle softblue">
              <i class="fas fa-right-left fa-2x text-primary p-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card shadow rounded-card h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                Produk yang terjual bulan ini
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalProductsSoldThisMonth }}
              </div>
            </div>
            <div class="col-auto rounded-circle softyellow">
              <i class="fas fa-shopping-bag fa-2x text-warning p-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card shadow rounded-card h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                Stok Produk
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                {{ $totalStockAvailable }}
              </div>
            </div>
            <div class="col-auto rounded-circle softred">
              <i class="fas fa-dolly fa-2x text-danger p-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->

  <div class="row">
    <!-- Tabel pencapaian bulanan -->
    <div class="col-xl-8 col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">
            Pencapaian Penjualan Tiap Bulan
          </h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Tota Transaksi</th>
                <th>Total Pendapatan</th>
              </tr>
            </thead>
            <tbody>
            <tbody>
              @foreach($salesData as $data)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}</td>
                <td>{{ $data->total_transaksi }}</td>
                <td>Rp. {{ number_format($data->total_harga, 0, 2) }}</td>
              </tr>
              @endforeach
            </tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--top seller-->
    <div class="col-xl-4 col-lg-12">
      <div class="card shadow mb-4 rounded-card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-secondary">
            Produk terlaris
          </h6>
          <a href="{{ route('laporan') }}" class="font-weight-bold text-secondary">Selengkapnya</a>
        </div>
        <div class="card-body pt-2 pb-4 mx-3">
          @foreach ($bestSellingProducts as $item)
          <div class="row border shadow rounded p-2 my-2">
            <div class="col-3">
              <img src="{{ asset('storage/product/' . $item->product->gambar) }}" alt="kanzler" class="top-products" />
            </div>
            <div class="col-6">
              <strong>{{ $item->product->nama }}</strong><br />
              <small>Rp. {{ number_format($item->product->harga, 0, 2) }}</small>
            </div>
            <div class="col-3">
              <strong>Terjual</strong><br />
              <span class="badge badge-success">{{ $item->product->terjual }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection