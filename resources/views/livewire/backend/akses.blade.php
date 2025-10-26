@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}" />
    <style>
        .edit-icon .icon-hover {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #6c757d;
        }

        .edit-icon:hover .icon-hover {
            opacity: 1;
        }
    </style>
@endpush

<div>
    <h4 class="fw-bold py-3 mb-2">
        <span class="text-muted fw-light">Setting /</span>
        {{ strtolower(Request::segment(1)) === 'livewire' ? $fallback : ucfirst(Request::segment(1)) }}
        {{-- @can('c_' . Request::segment(1))
            <button wire:click="tambah" type="button" class="btn btn-xs btn-primary rounded-1"><strong>&#10010;</strong></button>
        @endcan --}}
    </h4>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="p-4 table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="col-auto text-start">Menu</th>
                                <th class="col-auto text-start">Role</th>
                                <th class="col-1">Create</th>
                                <th class="col-1">Read</th>
                                <th class="col-1">Update</th>
                                <th class="col-1">Delete</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($menus as $menu)
                                @php
                                    $groups = $this->groupRolesByPermissions($menu, $roles);
                                @endphp

                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{ ucfirst($menu->menu) }}</td>

                                        <td class="text-start" x-data="{ editing: false }" x-init="$watch('editing', value => {
                                            if (value) Alpine.store('akses').open = $el;
                                            else if (Alpine.store('akses').open === $el) Alpine.store('akses').open = null;
                                        })">

                                            <div x-show="!editing" @click="if(!Alpine.store('akses').open) editing = true" style="cursor:pointer; position:relative;"
                                                class="edit-icon">
                                                {{ collect($group['roles'])->pluck('name')->implode(', ') ?: '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>

                                            <div x-show="editing" x-cloak wire:ignore class="flex items-center gap-2">
                                                <select class="roles form-select" data-menu-id="{{ $menu->id }}" multiple="multiple" style="width:100%;" x-ref="select">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" @selected(collect($group['roles'])->pluck('id')->contains($role->id))>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <i class="bx bx-check text-primary ms-1" style="cursor:pointer;"
                                                    @click="editing = false;$wire.saveRole({{ $menu->id }}, [...$refs.select.selectedOptions].map(o => o.value));">
                                                </i>


                                            </div>
                                        </td>

                                        @foreach (['c' => 'Create', 'r' => 'Read', 'u' => 'Update', 'd' => 'Delete'] as $code => $label)
                                            <td class="text-center">
                                                <input type="checkbox" value="{{ $code . '_' . $menu->menu }}"
                                                    wire:click="toggleGroupPermission({{ collect($group['roles'])->pluck('id') }}, '{{ $code . '_' . strtolower($menu->menu) }}')"
                                                    @checked($group['permissions'][$code])>
                                            </td>
                                        @endforeach

                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function initSelect2() {
            $('.roles').each(function() {
                // jika sudah jadi select2, destroy dulu biar tidak dobel
                if ($(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }

                $(this).select2({
                    width: '100%',
                    allowClear: false
                }).on('change', function(e) {
                    let data = $(this).val();
                    let menuId = $(this).data('menu-id');
                    @this.saveRole(menuId, data);
                });
            });
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('akses', {
                open: null // hanya boleh ada 1 yg terbuka
            });
        });

        document.addEventListener("livewire:init", () => {
            initSelect2();

            Livewire.hook('commit', ({
                component,
                commit,
                succeed
            }) => {
                succeed(() => {
                    initSelect2();
                });
            });
        });

        document.addEventListener("livewire:update", function() {
            initSelect2();
        });

        $(document).ready(function() {
            initSelect2();
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.Livewire.on('toast_success', function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: message
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            window.Livewire.on('toast_error', function(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: message
                });
            });
        });
    </script>
@endpush
