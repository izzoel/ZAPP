@push('css')
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
        @can('c_' . Request::segment(1))
            <button wire:click="tambah" type="button" class="btn btn-xs btn-primary rounded-1"><strong>&#10010;</strong></button>
        @endcan
    </h4>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="p-4 table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th class="col-1">#</th>
                                <th class="col-auto text-start">Menu</th>
                                <th class="col-2 text-start">Segment</th>
                                <th class="col-2">Icon
                                    <a href="/icon" target="_blank" rel="noopener noreferrer">
                                        <i class="bx bx-help-circle"></i>
                                    </a>
                                </th>
                                <th class="col-2">Parent</th>
                                @can('d_' . Request::segment(1))
                                    <th class="col-1">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($tampil_tambah)
                                <tr class="text-center" style="background-color: rgb(133 146 163 / 60%);">
                                    <td>
                                        <input wire:model="urutan" type="text"
                                            class="form-control form-control-md {{ $errors->has('urutan') ? 'is-invalid' : 'border border-secondary' }}" placeholder="ke..">

                                        <div class="invalid-feedback">
                                            @error('urutan')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input wire:model="menu" type="text"
                                            class="form-control form-control-md {{ $errors->has('menu') ? 'is-invalid' : 'border border-secondary' }}" placeholder="nama menu..">

                                        <div class="invalid-feedback">
                                            @error('menu')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input wire:model="segment" type="text"
                                            class="form-control form-control-md {{ $errors->has('segment') ? 'is-invalid' : 'border border-secondary' }}" placeholder="segment..">

                                        <div class="invalid-feedback">
                                            @error('segment')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <input wire:model="icon" type="text"
                                            class="form-control form-control-md {{ $errors->has('icon') ? 'is-invalid' : 'border border-secondary' }}" placeholder="bx-user">

                                        <div class="invalid-feedback">
                                            @error('icon')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <select wire:model="parent_id" class="form-select form-select-md border border-secondary ">
                                            <option value="">None</option>
                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id }}">
                                                    {{ $menu->menu }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button onclick="simpanMenu()" type="button" class="btn btn-sm btn-primary rounded-1">
                                            <strong>Simpan</strong>
                                        </button>

                                    </td>
                                </tr>
                            @endif

                            @foreach ($menus as $menu)
                                <tr class="text-center {{ $menu->parent_id == null ? 'bg-secondary text-white' : '' }}">
                                    <td>
                                        @if ($editFieldRowId == $menu->id . '-urutan')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $menu->id }}', 'urutan', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $menu->id }}', 'urutan', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $menu->urutan }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $menu->id }}', 'urutan', '{{ $menu->urutan }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $menu->urutan ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($editFieldRowId == $menu->id . '-menu')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $menu->id }}', 'menu', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $menu->id }}', 'menu', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $menu->menu }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $menu->id }}', 'menu', '{{ $menu->menu }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $menu->menu ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($editFieldRowId == $menu->id . '-segment')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $menu->id }}', 'segment', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $menu->id }}', 'segment', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $menu->segment }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $menu->id }}', 'segment', '{{ $menu->segment }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $menu->segment ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    <td>
                                        @if ($editFieldRowId == $menu->id . '-icon')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $menu->id }}', 'icon', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $menu->id }}', 'icon', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $menu->icon }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $menu->id }}', 'icon', '{{ $menu->icon }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">

                                                <i class="bx {{ $menu->icon }} fs-3"></i>
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($editFieldRowId == $menu->id . '-parent_id')
                                            <div class="d-flex justify-content-center" @click.outside="$wire.set('editFieldRowId', null)">
                                                <select wire:blur="ubah('{{ $menu->id }}', 'parent_id', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $menu->id }}', 'parent_id', $event.target.value)" class="form-select form-select-sm">
                                                    <option value="" {{ is_null($menu->parent_id) ? 'selected' : '' }}>None</option>
                                                    @foreach ($semuaMenu->whereNull('parent_id') as $m)
                                                        @if ($m->id != $menu->id)
                                                            <option value="{{ $m->id }}" {{ $menu->parent_id == $m->id ? 'selected' : '' }}>
                                                                {{ $m->menu }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $menu->id }}', 'parent_id', '{{ $menu->parent_id }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                <span class="badge {{ $menu->parent ? 'bg-label-success' : 'bg-label-warning' }} me-1">
                                                    {{ $menu->parent?->menu ?? 'Null' }}
                                                </span>
                                                <i class="bx bx-edit-alt text-warning icon-hover" style="position: absolute; right: 0;"></i>
                                            </div>
                                        @endif
                                    </td>

                                    @can('d_' . Request::segment(1))
                                        <td>
                                            <div class="dropdown">
                                                <button onclick="konfirmasiHapus({{ $menu->id }}, '{{ 'Menu ' . addslashes($menu->menu) }}')" type="button"
                                                    class="btn btn-sm btn-danger rounded-1"><strong>Hapus</strong></button>
                                            </div>
                                        </td>
                                    @endcan
                                    {{-- <td>
                                        <div class="dropdown">
                                            <button onclick="konfirmasiHapus({{ $menu->id }}, '{{ 'Menu ' . addslashes($menu->menu) }}')" type="button"
                                                class="btn btn-sm btn-danger rounded-1" @cannot('d') disabled @endcannot><strong>Hapus</strong></button>
                                        </div>
                                    </td> --}}
                                </tr>
                                @foreach ($menu->children as $child)
                                    <tr class="text-center">
                                        <td>
                                            @if ($editFieldRowId == $child->id . '-urutan')
                                                <div class="d-flex justify-content-center">
                                                    <input wire:blur="ubah('{{ $child->id }}', 'urutan', $event.target.value)"
                                                        wire:keydown.enter="ubah('{{ $child->id }}', 'urutan', $event.target.value)" class="form-control form-control-sm"
                                                        value="{{ $child->urutan }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                                </div>
                                            @else
                                                <div wire:click="editRow('{{ $child->id }}', 'urutan', '{{ $child->urutan }}')" class="edit-icon"
                                                    style="cursor: pointer; position: relative;">
                                                    {{ $child->urutan ?? '---' }}
                                                    <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            @if ($editFieldRowId == $child->id . '-menu')
                                                <div class="d-flex justify-content-center">
                                                    <input wire:blur="ubah('{{ $child->id }}', 'menu', $event.target.value)"
                                                        wire:keydown.enter="ubah('{{ $child->id }}', 'menu', $event.target.value)" class="form-control form-control-sm"
                                                        value="{{ $child->menu }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                                </div>
                                            @else
                                                <div wire:click="editRow('{{ $child->id }}', 'menu', '{{ $child->menu }}')" class="edit-icon"
                                                    style="cursor: pointer; position: relative;">
                                                    {{ $child->menu ?? '---' }}
                                                    <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            @if ($editFieldRowId == $child->id . '-segment')
                                                <div class="d-flex justify-content-center">
                                                    <input wire:blur="ubah('{{ $child->id }}', 'segment', $event.target.value)"
                                                        wire:keydown.enter="ubah('{{ $child->id }}', 'segment', $event.target.value)" class="form-control form-control-sm"
                                                        value="{{ $child->segment }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                                </div>
                                            @else
                                                <div wire:click="editRow('{{ $child->id }}', 'segment', '{{ $child->segment }}')" class="edit-icon"
                                                    style="cursor: pointer; position: relative;">
                                                    {{ $child->segment ?? '---' }}
                                                    <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                                </div>
                                            @endif
                                        <td>
                                            @if ($editFieldRowId == $child->id . '-icon')
                                                <div class="d-flex justify-content-center">
                                                    <input wire:blur="ubah('{{ $child->id }}', 'icon', $event.target.value)"
                                                        wire:keydown.enter="ubah('{{ $child->id }}', 'icon', $event.target.value)" class="form-control form-control-sm"
                                                        value="{{ $child->icon }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                                </div>
                                            @else
                                                <div wire:click="editRow('{{ $child->id }}', 'icon', '{{ $child->icon }}')" class="edit-icon"
                                                    style="cursor: pointer; position: relative;">

                                                    <i class="bx {{ $child->icon }} fs-3"></i>
                                                    <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($editFieldRowId == $child->id . '-parent_id')
                                                <div class="d-flex justify-content-center" @click.outside="$wire.set('editFieldRowId', null)">
                                                    <select wire:blur="ubah('{{ $child->id }}', 'parent_id', $event.target.value)"
                                                        wire:keydown.enter="ubah('{{ $child->id }}', 'parent_id', $event.target.value)" class="form-select form-select-sm">
                                                        <option value="" {{ is_null($child->parent_id) ? 'selected' : '' }}>None</option>
                                                        @foreach ($semuaMenu->whereNull('parent_id') as $m)
                                                            @if ($m->id != $child->id)
                                                                <option value="{{ $m->id }}" {{ $child->parent_id == $m->id ? 'selected' : '' }}>
                                                                    {{ $m->menu }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <div wire:click="editRow('{{ $child->id }}', 'parent_id', '{{ $child->parent_id }}')" class="edit-icon"
                                                    style="cursor: pointer; position: relative;">
                                                    <span class="badge {{ $child->parent ? 'bg-label-success' : 'bg-label-warning' }} me-1">
                                                        {{ $child->parent?->menu ?? 'Null' }}
                                                    </span>
                                                    <i class="bx bx-edit-alt text-warning icon-hover" style="position: absolute; right: 0;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        @can('d_' . Request::segment(1))
                                            <td>
                                                <button onclick="konfirmasiHapus({{ $child->id }}, '{{ 'Menu ' . addslashes($child->menu) }}')" type="button"
                                                    class="btn btn-sm btn-danger rounded-1">
                                                    <strong>Hapus</strong>
                                                </button>
                                            </td>
                                        @endcan
                                        {{-- <td>
                                            <button onclick="konfirmasiHapus({{ $child->id }}, '{{ 'Menu ' . addslashes($child->menu) }}')" type="button"
                                                class="btn btn-sm btn-danger rounded-1" @cannot('d') disabled @endcannot>
                                                <strong>Hapus</strong>
                                            </button>
                                        </td> --}}
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


        function simpanMenu() {
            Livewire.dispatch('simpanMenu');
        }

        function konfirmasiHapus(id, menu) {
            Swal.fire({
                title: 'Konfirmasi hapus',
                text: "Anda yakin ingin menghapus " + menu + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('hapusMenu', {
                        id: id
                    });
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    Toast.fire({
                        icon: "success",
                        title: menu + " telah dihapus."
                    });
                }
            });
        }
    </script>
@endpush
