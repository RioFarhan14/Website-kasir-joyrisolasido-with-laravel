const csrfToken = $('meta[name="csrf-token"]').attr("content");
$(document).on("click", "#btn-add", function (e) {
    e.preventDefault(); // Perbaiki pemanggilan fungsi preventDefault

    Swal.fire({
        title: "Tambah data pencapaian bulanan",
        width: "70%",
        html: `
            <form id="editForm" class="container-fluid">
                <div class="form-group row">
                    <label for="bulanTahun" class="col-sm-4 col-form-label">Bulan dan Tahun:</label>
                    <div class="col-sm-8">
                        <input type="month" id="bulanTahun" name="bulanTahun" class="form-control" required>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="totalTransaksi" class="col-sm-4 col-form-label">Total Transaksi:</label>
                    <div class="col-sm-8">
                        <input type="number" id="totalTransaksi" name="totalTransaksi" class="form-control" required>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="totalPendapatan" class="col-sm-4 col-form-label">Total Pendapatan:</label>
                    <div class="col-sm-8">
                        <input type="number" id="totalPendapatan" name="totalPendapatan" class="form-control" required>
                    </div>
                </div>
            </form>`,
        confirmButtonText: "Simpan",
        confirmButtonColor: "#26A65B",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // Retrieve edited data
            const bulanTahun = $("#bulanTahun").val();
            const totalTransaksi = $("#totalTransaksi").val();
            const totalPendapatan = $("#totalPendapatan").val();
            return {
                bulanTahun,
                totalTransaksi,
                totalPendapatan,
            };
        },
    }).then((result) => {
        const add = result.value;
        $.ajax({
            url: "/sales/add",
            type: "POST",
            data: add,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                Swal.fire({
                    title: "Success",
                    text: response.message,
                    icon: "success",
                    preConfirm: () => {
                        refresh();
                    },
                });
            },
            error: function (xhr, status, error) {
                let errorMessage = "Data yang dimasukkan tidak valid.";
                if (xhr.status === 404) {
                    errorMessage = xhr.responseJSON.error; // Ambil pesan error dari respons JSON
                }

                Swal.fire({
                    title: "Error",
                    text: errorMessage,
                    icon: "error",
                });
                console.error("Error:", error);
            },
        });
    });
});

$(document).on("click", ".btn-edit", function (e) {
    e.preventDefault();
    let data = $(this).data("sale-id");
    $.ajax({
        url: "/sales/" + data,
        type: "GET",
        success: function (response) {
            Swal.fire({
                title: "Edit Pencapaian Bulanan",
                width: "70%",
                html: `
                    <form id="editForm" class="container-fluid">
                    <input type="text" id="sale_id" value="${response.sale.id}" hidden>
                        <div class="form-group row">
                            <label for="bulanTahun" class="col-sm-4 col-form-label">Bulan dan Tahun:</label>
                            <div class="col-sm-8">
                                <input type="month" id="bulanTahun" name="bulanTahun" class="form-control" value="${response.sale.month}" required>
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label for="totalTransaksi" class="col-sm-4 col-form-label">Total Transaksi:</label>
                            <div class="col-sm-8">
                                <input type="number" id="totalTransaksi" name="totalTransaksi" class="form-control" value="${response.sale.total_transaksi}" required>
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label for="totalPendapatan" class="col-sm-4 col-form-label">Total Pendapatan:</label>
                            <div class="col-sm-8">
                                <input type="number" id="totalPendapatan" name="totalPendapatan" class="form-control" value="${response.sale.total_harga}" required>
                            </div>
                        </div>
                    </form>`,
                confirmButtonText: "Edit",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    // Retrieve edited data
                    const bulanTahun = $("#bulanTahun").val();
                    const totalTransaksi = $("#totalTransaksi").val();
                    const totalPendapatan = $("#totalPendapatan").val();
                    const sale_id = $("#sale_id").val();

                    return {
                        bulanTahun,
                        totalTransaksi,
                        totalPendapatan,
                        sale_id,
                    };
                },
            }).then((result) => {
                // Check if the user clicked the "Edit" button
                if (result.isConfirmed) {
                    const editedData = result.value;
                    $.ajax({
                        url: "/sales/update",
                        type: "PUT",
                        data: editedData,
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "Success",
                                text: response.message,
                                icon: "success",
                                preConfirm: () => {
                                    refresh();
                                },
                            });
                        },
                        error: function (xhr, status, error) {
                            let errorMessage =
                                "Data yang dimasukkan tidak valid.";

                            if (xhr.status === 404) {
                                errorMessage = xhr.responseJSON.error; // Ambil pesan error dari respons JSON
                            }

                            Swal.fire({
                                title: "Error",
                                text: errorMessage,
                                icon: "error",
                            });
                            console.error("Error:", error);
                        },
                    });
                }
            });
        },
    });
});
$(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    let data = $(this).data("sale-id");
    Swal.fire({
        title: "Apakah anda yakin ?",
        text: "Perubahan ini permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#eb4034",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/sales/delete/" + data,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        preConfirm: () => {
                            refresh();
                        },
                    });
                },
                error: function (xhr, status, error) {
                    let errorMessage = "Data tidak ditemukkan.";

                    if (xhr.status === 404) {
                        errorMessage = xhr.responseJSON.error; // Ambil pesan error dari respons JSON
                    }

                    Swal.fire({
                        title: "Error",
                        text: errorMessage,
                        icon: "error",
                    });
                    console.error("Error:", error);
                },
            });
        }
    });
});

function refresh() {
    location.reload();
}
