$(document).ready(function () {
    updateCartContent();
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
});
