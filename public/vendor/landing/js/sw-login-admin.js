$(document).ready(function () {
    const name = "admin";

    $("#x").on("click", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Sst.. Passwordnya?",
            input: "password",
            showCancelButton: true,
            confirmButtonText: "Login",
            showLoaderOnConfirm: true,
            preConfirm: async (password) => {
                try {
                    const response = await $.ajax({
                        url: "/login", // Replace with your login URL
                        method: "POST",
                        data: {
                            name: name,
                            password: password,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        dataType: "json",
                    });

                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                        }).then(() => {
                            window.location.href = "/admin";
                        });
                    } else {
                        Swal.showValidationMessage(`Password Salah!`);
                    }
                } catch (error) {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        });
    });
});
