<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu fs-1"></i>
        </a>
    </div>
    <div class="navbar-nav-left d-flex align-items-center" id="navbar-collapse-left">
        <ul class="navbar-nav flex-row align-items-center">
            <li>
                <a wire:navigate href="/admin" class="nav-link">Admin</a>
            </li>
            @if (Request::segment(1) != 'admin')
                <div class="text-muted fw-semibold px-2 fs-5"> / </div>
                <li>
                    <a class="nav-link" href="/{{ Request::segment(1) }}">{{ ucfirst(Request::segment(1)) }}</a>
                </li>
            @endif
        </ul>
    </div>
    <div class="navbar-nav-right d-flex align-items-center ms-3" id="navbar-collapse-right">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('img/avatars/' . (auth()->user()->avatar ?? '0.png')) }}" alt="avatar-{{ auth()->user()->avatar ?? '0.png' }}"
                            class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ url('user') }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('img/avatars/' . (auth()->user()->avatar ?? '0.png')) }}" alt="avatar-{{ auth()->user()->avatar ?? '0.png' }}"
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ ucfirst(auth()->user()->name) }}</span>
                                    {{-- <small class="text-muted">{{ auth()->user()->role->role }}</small> --}}
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class=" dropdown-item d-inline-flex align-items-center" href="{{ url('user') }}">
                            <i class="menu-icon tf-icons bx bx-cog me-2"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item  d-inline-flex align-items-center" href="{{ route('logout') }}">
                            <i class="menu-icon tf-icons bx bx-door-open me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

@push('js')
    <script>
        $(document).ready(function() {
            // Klik icon menu
            $('.nav-item.nav-link.px-0.me-xl-4').on('click', function(e) {
                e.preventDefault();
                $('.layout-wrapper').toggleClass('layout-menu-expanded');
            });

            // Klik overlay → tutup sidebar
            $('.sidebar-overlay').on('click', function() {
                $('.layout-wrapper').removeClass('layout-menu-expanded');
            });
            $('.bx-chevron-left').on('click', function() {
                $('.layout-wrapper').removeClass('layout-menu-expanded');
            });
        });
    </script>
@endpush
