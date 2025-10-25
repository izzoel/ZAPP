$(document).ready(function () {
    $("#login").on("click", function (event) {
        event.preventDefault(); // Prevent the default form submission behavior

        Swal.fire({
            html:
                '<input type="text" id="username" class="swal2-input" placeholder="username">' +
                '<input type="password" id="password" class="swal2-input" placeholder="Password">' +
                '<wdiv class="swal2-radio">' +
                "</wdiv>",
            showCancelButton: true,
            confirmButtonText: "Login",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                const username = $("#username").val();
                const password = $("#password").val();

                try {
                    const response = await $.ajax({
                        url: "/login", // Replace with your login URL
                        method: "POST",
                        data: {
                            name: username,
                            password: password,
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ), // Include CSRF token
                        },
                        dataType: "json",
                    });

                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            icon: "success",
                        }).then(() => {
                            window.location.href = "/admin"; // Redirect to the dashboard or another page
                        });
                    } else {
                        Swal.showValidationMessage(
                            `Username atau Password Salah!`
                        );
                    }
                } catch (error) {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        });
    });
});
