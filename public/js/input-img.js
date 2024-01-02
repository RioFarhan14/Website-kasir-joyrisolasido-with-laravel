document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("gambar-input")
        .addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("preview-image").src =
                        e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById("preview-image").src =
                    "{{ asset('img/no-picture.png') }}";
            }
        });
});
