<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet" />
  <link href="{{asset('css/custom.css')}}" rel="stylesheet" />
</head>

<body>
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <strong>INVOICE</strong>
        <strong>{{ $invoice->id }}</strong>
        <span class="float-right">
          <strong>Tanggal</strong> <strong>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y')
            }}</strong></span>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <img src="{{ asset('img/joyrisolasido.jpeg') }}" width="100px" alt="" />
          </div>
        </div>
        <div class="table-responsive-sm">
          <table class="table table-striped">
            <thead>
              <tr>
                <th class="center">#</th>
                <th>Gambar</th>
                <th>Nama</th>

                <th class="right">Harga</th>
                <th class="center">Qty</th>
                <th class="right">Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $index => $product)
              <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td class="left strong">
                  <img src="{{ asset('storage/product/' . $product->product->gambar) }}" height="70px" width="70px"
                    alt="" />
                </td>
                <td class="left">{{ $product->product->nama }}</td>
                <td class="right">Rp. {{ number_format($product->product->harga, 0, 2) }}
                </td>
                <td class="center">{{ $product->jumlah_produk }}</td>
                <td class="right">Rp. {{ number_format($product->product->harga *
                  $product->jumlah_produk, 0, 2) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-5"></div>

          <div class="col-lg-4 col-sm-5 ml-auto">
            <table class="table table-clear">
              <tbody>
                <tr>
                  <td class="left">
                    <strong>Metode Pembayaran</strong>
                  </td>
                  <td class="right"><strong>{{ $invoice->metode_pembayaran }}</strong></td>
                </tr>
                <tr>
                  <td class="left">
                    <strong>Total</strong>
                  </td>
                  <td class="right">
                    <strong>Rp. {{ number_format($invoice->total_harga, 0, 2) }}</strong>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>