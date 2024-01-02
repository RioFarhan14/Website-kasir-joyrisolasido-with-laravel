@foreach ($products as $item)
<button class="product-btn rounded-card not-border col-3 px-3 py-3 shadow mx-2 my-2" data-product-id="{{ $item->id }}">
    <div class="d-flex flex-column align-items-center">
        <div class="col-12 mb-2 d-flex justify-content-end">
            <span class="badge badge-success">{{ $item->stok }}</span>
        </div>
        <div class="d-flex flex-column align-items-center">
            <img class="mb-2 rounded-card" width="100px" height="90px"
                src="{{ asset('storage/product/'.$item->gambar) }}" alt="product" />
            <span class="text-center mb-1">{{ $item->nama }}</span>
            <span class="text-center">Rp. {{ number_format($item->harga, 0, 2) }}</span>
        </div>
    </div>
</button>
@endforeach

<script>
    function updateCartContent() {
        $.ajax({
            url: "/pembayaran/checkout",
            method: "GET",
            success: function (response) {
                $("#list-checkout").html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(
                    "Error fetching cart data:",
                    textStatus,
                    errorThrown,
                    jqXHR.responseText // Tambahkan ini untuk melihat pesan error dari server
                );
            },
        });
    }
    $(document).ready(function () {
        $(".product-btn").on("click", function () {
            let product_id = $(this).data("product-id");

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
        });
    });
</script>