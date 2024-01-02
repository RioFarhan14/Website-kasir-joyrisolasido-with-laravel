<!-- Daftar Produk yang Dibeli -->
<div class="checkout-item">
    <div class="row">
        @foreach ($cart as $item)
        <div class="col-12 my-1">
            <div class="row">
                <!-- Gambar Produk -->
                <div class="col-8">
                    <div class="row">
                        <div class="col-3 product-checkout">
                            <img src="{{ asset('storage/product/'. $item['product']['gambar']) }}" alt=""
                                height="50px" />
                        </div>
                        <!-- Nama Produk -->
                        <div class="col-9 pt-1">
                            <span>{{ $item['product']['nama'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Produk -->
                <div class="col-4 product-qty d-flex mt-4">
                    <button class="minus-btn" data-product-id="{{ $item['product']['id'] }}">-</button>
                    <input type="text" value="{{ $item['quantity'] }}" />
                    <button class="plus-btn" data-product-id="{{ $item['product']['id'] }}">+</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Total Pembayaran -->
<div class="col-12 text-right">
    <h5 class="font-weight-bold">Total : Rp. {{ number_format($totalPrice, 0, 2) }},-</h5>
</div>

<script>
    function updateCartContent() {
        $.ajax({
            url: "/pembayaran/checkout",
            method: "GET",
            success: function (response) {
                $("#list-checkout").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error fetching cart data:", textStatus, errorThrown, jqXHR.responseText);
            },
        });
    }

    function addProduct(product_id) {
        $.ajax({
            url: "/add-product/" + product_id,
            method: "GET",
            success: function (response) {
                if (response.updateCart) {
                    updateCartContent();
                }
            },
            error: function (error) {
                console.log(error);
                // Anda bisa menambahkan kode lain di sini untuk menangani kesalahan
            },
        });
    }

    function removeProduct(product_id) {
    console.log("Menghapus produk dengan ID:", product_id);  // Debugging line
    $.ajax({
        url: "/remove-product/" + product_id,
        method: "GET",
        success: function (response) {
            console.log("Respon setelah menghapus:", response);  // Debugging line
            if (response.updateCart) {
                updateCartContent();
            }
        },
        error: function (error) {
            console.log(error);
            // Anda bisa menambahkan kode lain di sini untuk menangani kesalahan
        },
    });
}

    $(document).ready(function () {
        $(".plus-btn").on("click", function () {
            let product_id = $(this).data("product-id");
            addProduct(product_id);
        });

        $(".minus-btn").on("click", function () {
            let product_id = $(this).data("product-id");
            removeProduct(product_id);
        });
    });
</script>