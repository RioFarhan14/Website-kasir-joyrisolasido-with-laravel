$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    function togglePopup() {
        let selectedPaymentMethod =
            $(".debitbutton.active").length > 0
                ? "debit"
                : $(".tunaibutton.active").length > 0
                ? "tunai"
                : null;

        $.ajax({
            url: "/validatePayment",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                paymentMethod: selectedPaymentMethod,
            },
            success: function (response) {
                if (response.status === true) {
                    Swal.fire({
                        title: "IDENTITAS PELANGGAN",
                        html: `
                        <div class="form-identitas">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <a class="col-6 m-2 btn-customer" id="new-customer">Pelanggan baru</a>
                                <a class="col-6 m-2 btn-customer" id="old-customer">Pelanggan lama</a>
                            </div>
                            <!-- Contoh form untuk pelanggan baru -->
                            <div class="container-fluid new-customer mt-4" id="new-customer-form">
                                <div class="form-customer col-7"> <!-- Mengganti col-9 menjadi col-7 -->
                                    <div class="from-group p-2 text-left">
                                        <label for="name">Nama</label>
                                        <input type="text" id="new-nama" class="form-control">
                                    </div>
                                    <div class="from-group p-2 text-left">
                                        <label for="telepon">No.telepon</label>
                                        <input type="text" id="new-telepon" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="button" class="btn-form-customer" id="validation-new">OK</button>
                                </div>
                            </div>
                            <!-- Contoh form untuk pelanggan lama -->
                            <div class="container-fluid old-customer mt-3" id="old-customer-form">
                                <div class="form-customer col-7"> <!-- Mengganti col-9 menjadi col-7 -->
                                    <div class="from-group p-2 text-left">
                                        <label for="telepon">No.telepon</label>
                                        <input type="text" id="telepon" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="button" class="btn-form-customer" id="validation-old">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                        `,
                        showCancelButton: false,
                        showConfirmButton: false,
                        showCloseButton: true,
                        width: "50%",
                        padding: "2rem",
                        background: "#fff",
                        allowOutsideClick: false,
                        customClass: {
                            popup: "custom-modal",
                        },
                        didOpen: function () {
                            const btncustomernew =
                                document.getElementById("new-customer");
                            const btncustomerold =
                                document.getElementById("old-customer");
                            const newformcustomer =
                                document.getElementById("new-customer-form");
                            const oldformcustomer =
                                document.getElementById("old-customer-form");

                            btncustomernew.addEventListener(
                                "click",
                                toggleForms
                            );
                            btncustomerold.addEventListener(
                                "click",
                                toggleForms
                            );

                            function toggleForms(event) {
                                event.preventDefault();

                                if (event.target === btncustomernew) {
                                    newformcustomer.style.display = "block";
                                    oldformcustomer.style.display = "none";
                                    btncustomernew.classList.add("active");
                                    btncustomerold.classList.remove("active");
                                } else if (event.target === btncustomerold) {
                                    oldformcustomer.style.display = "block";
                                    newformcustomer.style.display = "none";
                                    btncustomerold.classList.add("active");
                                    btncustomernew.classList.remove("active");
                                }
                            }
                            const validationOldBtn =
                                document.getElementById("validation-old");
                            const validationNewBtn =
                                document.getElementById("validation-new");
                            validationOldBtn.addEventListener(
                                "click",
                                function () {
                                    const teleponValue =
                                        document.getElementById(
                                            "telepon"
                                        ).value;
                                    if (!teleponValue) {
                                        Swal.fire({
                                            title: "Error",
                                            text: "No. telepon tidak boleh kosong!",
                                            icon: "error",
                                            confirmButtonText: "OK",
                                        });
                                        return;
                                    }
                                    $.ajax({
                                        url: "/validationform", // Gantikan dengan path yang benar ke controller Anda
                                        type: "POST",
                                        data: {
                                            telepon: teleponValue,
                                        },
                                        headers: {
                                            "X-CSRF-TOKEN": csrfToken,
                                        },
                                        success: function (response) {
                                            if (response.status) {
                                                Swal.fire({
                                                    text: response.message, // Pastikan bahwa respons dari server memiliki properti "message"
                                                    icon: "success",
                                                    showCancelButton: false,
                                                    showConfirmButton: false,
                                                    footer: `
                                                    <div class="container my-4 d-flex flex-row justify-content-around align-items-center">
                                                        <a class="btn btn-success col-4 text-white text-center" href="/downloadInvoice/${response.id}">Cetak Invoice</a>
                                                        <a class="btn btn-success col-4 text-white text-center" href="/pembayaran">OK</a>
                                                    </div>
                                                    `,
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: "Error",
                                                    text: response.message,
                                                    icon: "error",
                                                    confirmButtonText: "OK",
                                                });
                                            }
                                        },
                                        error: function (error) {
                                            console.error("Error:", error);
                                        },
                                    });
                                }
                            );
                            validationNewBtn.addEventListener(
                                "click",
                                function () {
                                    const teleponValue =
                                        document.getElementById(
                                            "new-telepon"
                                        ).value;
                                    const namaValue =
                                        document.getElementById(
                                            "new-nama"
                                        ).value;
                                    if (!teleponValue || !namaValue) {
                                        Swal.fire({
                                            title: "Error",
                                            text: "Nama dan no.telepon wajib diisi !!",
                                            icon: "error",
                                            confirmButtonText: "OK",
                                        });
                                        return;
                                    }
                                    $.ajax({
                                        url: "/validationform", // Gantikan dengan path yang benar ke controller Anda
                                        type: "POST",
                                        data: {
                                            nama: namaValue,
                                            telepon: teleponValue,
                                        },
                                        headers: {
                                            "X-CSRF-TOKEN": csrfToken,
                                        },
                                        success: function (response) {
                                            if (response.status) {
                                                Swal.fire({
                                                    text: response.message, // Pastikan bahwa respons dari server memiliki properti "message"
                                                    icon: "success",
                                                    showCancelButton: false,
                                                    showConfirmButton: false,
                                                    footer: `
                                                    <div class="container my-4 d-flex flex-row justify-content-around align-items-center">
                                                        <a class="btn btn-success col-4 text-white text-center" href="/downloadInvoice/${response.id}">Cetak Invoice</a>
                                                        <a class="btn btn-success col-4 text-white text-center" href="/pembayaran">OK</a>
                                                    </div>
                                                    `,
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: "Error",
                                                    text: response.message,
                                                    icon: "error",
                                                    confirmButtonText: "OK",
                                                });
                                            }
                                        },
                                        error: function (error) {
                                            console.error("Error:", error);
                                        },
                                    });
                                }
                            );
                        },
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Masukkan data: " + response.message,
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    }

    $("#bayarButton").on("click", function () {
        togglePopup();
    });

    $(".debitbutton, .tunaibutton").on("click", function () {
        $(".debitbutton, .tunaibutton").removeClass("active");
        $(this).addClass("active");
    });
});
