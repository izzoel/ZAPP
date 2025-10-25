<script src="{{ asset('vendor/sneat/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/sneat/libs/popper/popper.js') }}"></script>
<script src="{{ asset('vendor/sneat/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/sneat/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('vendor/sneat/js/menu.js') }}"></script>
<script src="{{ asset('vendor/sneat/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('vendor/sneat/js/ui-popover.js') }}"></script>
<script src="{{ asset('vendor/sneat/js/ui-toasts.js') }}"></script>
<script src="{{ asset('vendor/sweetalert2/js/sweetalert2.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.layout-menu-toggle a')
            .addEventListener('click', function(e) {
                e.preventDefault();
                console.log('[DEBUG] Sidebar toggle clicked');

                // Kirim event global ke semua komponen Livewire yang aktif
                Livewire.dispatch('showSidebar');

                console.log('[DEBUG] Livewire event "showSidebar2" dispatched');
            });
    });
</script>
