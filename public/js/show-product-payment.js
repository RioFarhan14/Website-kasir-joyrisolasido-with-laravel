$(document).ready(function () {
    $(".category-button").on("click", function () {
        let categoryId = $(this).data("category-id");
        $.ajax({
            url: "/get-products/" + categoryId,
            method: "GET",
            success: function (response) {
                $("#products-container").html(response);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
