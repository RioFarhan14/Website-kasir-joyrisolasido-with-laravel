const BASE_URL = "http://ppsi.test/";
$(document).ready(function () {
    // Event delegation untuk .showinvoice
    $(document).on("click", ".showinvoice", function (e) {
        e.preventDefault();
        let data = $(this).data("invoice-id");
        $.ajax({
            url: "/laporan/" + data,
            type: "GET",
            dataType: "json",
            success: function (response) {
                populateModal(response); // Mengisi konten modal dengan data yang diterima
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});

function populateModal(response) {
    let invoice = response.invoice;
    let products = response.products;

    let productsList = products
        .map(
            (product, index) => `
        <tr>
            <td class="center">${index + 1}</td>
            <td class="left strong">
                <img src="${assetPath(
                    "storage/product/" + product.product.gambar
                )}" height="70px" width="70px" alt="" />
            </td>
            <td class="left">${product.product.nama}</td>
            <td class="right">Rp. ${numberFormat(
                product.product.harga,
                0,
                "."
            )}</td>
            <td class="center">${product.jumlah_produk}</td>
            <td class="right">Rp. ${numberFormat(
                product.product.harga * product.jumlah_produk,
                0,
                "."
            )}</td>
        </tr>
    `
        )
        .join("");

    let modalContent = `
        <div class="card">
            <div class="card-header">
                <span class="float-right">
                    <strong>Tanggal</strong> <strong>${moment(
                        invoice.created_at
                    ).format("DD/MM/YYYY")}</strong>
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-2">
                        <img src="${assetPath(
                            "img/joyrisolasido.jpeg"
                        )}" width="100px" alt="" />
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
                            ${productsList}
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-7"></div>
                    <div class="col-lg-6 col-sm-7 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left"><strong>Metode Pembayaran</strong></td>
                                    <td class="right"><strong>${
                                        invoice.metode_pembayaran
                                    }</strong></td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Total</strong></td>
                                    <td class="right"><strong>Rp. ${numberFormat(
                                        invoice.total_harga,
                                        0,
                                        "."
                                    )}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `;

    Swal.fire({
        title: "Detail Invoice",
        width: "80%",
        html: modalContent,
        showCloseButton: true,
        showConfirmButton: false,
    });
}

function assetPath(path) {
    return BASE_URL + path;
}
function numberFormat(number, decimals, decPoint) {
    decPoint = typeof decPoint !== "undefined" ? decPoint : ".";
    decimals = !isNaN((decimals = Math.abs(decimals))) ? decimals : 2;

    let strNumber = parseFloat(number).toFixed(decimals);
    let parts = strNumber.split(".");
    let intPart = parts[0];
    let decPart = parts[1] ? decPoint + parts[1] : "";

    let formattedIntPart = "";
    for (let i = intPart.length - 1, j = 0; i >= 0; i--, j++) {
        if (j > 0 && j % 3 === 0) {
            formattedIntPart = "," + formattedIntPart;
        }
        formattedIntPart = intPart[i] + formattedIntPart;
    }

    return (number < 0 ? "-" : "") + formattedIntPart + decPart;
}
