@extends('layout.main')
@section('content-asset')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
@endsection
@section('content')
<div class="content-inventory p-4">
  <!-- Content Row -->
  <div class="row">
    <div class="col-12 my-3">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-secondary">
            Data Pelanggan
          </h6>
        </div>
        <div class="card-body">
          <table id="table-category" class="table table-striped" style="width: 100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Total transaksi</th>
                <th>Total Pembelian</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customers as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->totalTransaksi ?? 0 }}</td>
                <td>Rp. {{ number_format($item->totalPembelian, 0, 2) }}</td>
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