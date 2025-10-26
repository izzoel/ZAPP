@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/sneat/css/pages/page-icons.css') }}" />
@endpush

<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-2">
            <span class="text-muted fw-light">Informasi /</span>
            {{ ucfirst(Request::segment(1)) }}
        </h4>
        <p>
            Icon lengkap bisa di cek disini
            <a href="https://boxicons.com/" target="_blank">https://boxicons.com</a>
        </p>
        <div class="row">
            <div class="col">
                <div class="card pt-5 pb-5">
                    <div class="d-flex flex-wrap justify-content-center" id="icons-container">

                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-user mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">user</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-menu mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">menu</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-cog mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">cog</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-server mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">server</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-dashboard mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">dashboard</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-save mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">save</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-printer mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">printer</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-trash mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">trash</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-search mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">search</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-lock-open mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">lock-open</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-file mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">file</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-pencil mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">pencil</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-folder mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">folder</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-database mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">database</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-refresh-ccw mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">refresh-ccw</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-globe-alt mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">globe-alt</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-bell mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">bell</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-image mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">image</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-video mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">video</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-form mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">form</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-circle-hexagon mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">circle</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-camera-portrait mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">camera-portrait</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-user-hexagon mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">user-hexagon</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-user-circle mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">user-circle</p>
                            </div>
                        </div>
                        <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                            <div class="card-body">
                                <i class="bx bx-user-square mb-2"></i>
                                <p class="icon-name text-capitalize text-truncate mb-0">user-square</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(function() {
            $('.icon-card').on('click', function() {
                const iconElement = $(this).find('i');
                const bxClass = iconElement.attr('class').split(' ').find(cls => cls.startsWith('bx-'));

                if (bxClass) {
                    copyToClipboard(bxClass);
                } else {
                    alert('Class bx- tidak ditemukan!');
                }
            });

            function copyToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert("Disalin: " + text);
                    }).catch(err => {
                        alert("Gagal menyalin (clipboard API).");
                    });
                } else {
                    const $textArea = $('<textarea>')
                        .val(text)
                        .css({
                            position: 'fixed',
                            opacity: 0
                        })
                        .appendTo('body');

                    $textArea.focus().select();
                    try {
                        document.execCommand('copy');
                        alert("Disalin: " + text);
                    } catch (err) {
                        alert("Gagal menyalin.");
                    }
                    $textArea.remove();
                }
            }
        });
    </script>
@endpush
