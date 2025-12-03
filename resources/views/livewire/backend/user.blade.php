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

        /* Lingkaran upload dasar */
        .upload-plus {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .avatar-option {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        /* Hover: membesar dan bayangan */
        .avatar-option:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-color: #0d6efd;
        }

        /* Active (klik): mengecil sedikit */
        .avatar-option:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) inset;
        }
    </style>
@endpush

<div>
    <h4 class="fw-bold py-3 mb-2">
        <span class="text-muted fw-light">Setting /</span>
        {{ strtolower(Request::segment(1)) === 'livewire' ? $fallback : ucfirst(Request::segment(1)) }}
        @can('c_' . strtolower($fallback))
            <button wire:ignore wire:click="tambah" type="button" class="btn btn-xs btn-primary rounded-1"><strong>&#10010;</strong></button>
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
                                <th class="col-1">Avatar</th>
                                <th class="col-auto text-start">Nama</th>
                                <th class="col-auto text-start">Email</th>
                                <th class="col-2 text-start">Role</th>
                                <th class="col-2">Password</th>
                                @can('d_' . Request::segment(1))
                                    <th class="col-1">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($tampil_tambah)
                                <tr class="text-center" style="background-color: rgb(133 146 163 / 60%);">
                                    <td>{{ $index }}</td>
                                    <td>
                                        <div wire:click="$set('selectedUserId', null)" data-bs-toggle="modal" data-bs-target="#avatarModal" style="cursor: pointer;">
                                            <img src="{{ Str::contains($avatarBaru, 'avatar') ? asset('storage/img/avatars/avatar/' . $avatarBaru) : asset('img/avatars/' . ($avatarBaru ?? '0.png')) }}"
                                                class="w-px-40 h-auto rounded-circle">
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <input wire:model="name" type="text"
                                            class="form-control form-control-md {{ $errors->has('name') ? 'is-invalid' : 'border border-secondary' }}" placeholder="username..">

                                        <div class="invalid-feedback">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <input wire:model="email" type="text"
                                            class="form-control form-control-md {{ $errors->has('email') ? 'is-invalid' : 'border border-secondary' }}" placeholder="email..">

                                        <div class="invalid-feedback">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td class="text-start">
                                        <div class="d-flex justify-content-center">
                                            <div class="w-100">
                                                <select wire:model="role" class="form-select form-select-sm {{ $errors->has('role') ? 'is-invalid' : 'border border-secondary' }}">
                                                    <option value="">Pilih role...</option>
                                                    @foreach ($roles as $roleOpt)
                                                        <option value="{{ $roleOpt->name }}">{{ ucfirst(str_replace('_', ' ', $roleOpt->name)) }}</option>
                                                    @endforeach
                                                </select>

                                                <div class="invalid-feedback">
                                                    @error('role')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input wire:model="name" type="text"
                                            class="form-control form-control-md {{ $errors->has('name') ? 'is-invalid' : 'border border-secondary' }}" placeholder="password..">

                                        <div class="invalid-feedback">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <button onclick="simpanPengguna()" type="button" class="btn btn-sm btn-primary rounded-1">
                                            <strong>Simpan</strong>
                                        </button>
                                    </td>
                                </tr>
                            @endif

                            @foreach ($penggunas as $pengguna)
                                <tr class="text-center">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div wire:click="selectUser({{ $pengguna->id }})" data-bs-toggle="modal" data-bs-target="#avatarModal" style="cursor: pointer;">
                                            <img src="{{ asset((Str::contains($pengguna->avatar, 'custom-') ? 'storage/img/avatars/' . $pengguna->name . '/' : 'img/avatars/') . $pengguna->avatar) }}"
                                                alt="avatar-{{ $pengguna->avatar }}" class="w-px-40 h-auto rounded-circle">
                                        </div>
                                    </td>
                                    <td class="text-start" x-data>
                                        @if ($editFieldRowId == $pengguna->id . '-name')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $pengguna->id }}', 'name', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $pengguna->id }}', 'name', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $pengguna->name }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $pengguna->id }}', 'name', '{{ $pengguna->name }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $pengguna->name ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-start" x-data>
                                        @if ($editFieldRowId == $pengguna->id . '-email')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $pengguna->id }}', 'email', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $pengguna->id }}', 'email', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $pengguna->email }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $pengguna->id }}', 'email', '{{ $pengguna->email }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $pengguna->email ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        @if ($editFieldRowId == $pengguna->id . '-role_id')
                                            <div class="d-flex justify-content-center">
                                                <select wire:blur="ubah('{{ $pengguna->id }}', 'role', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $pengguna->id }}', 'role', $event.target.value)" class="form-select form-select-sm">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $pengguna->getRoleNames()->first() === $role->name ? 'selected' : '' }}>
                                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $pengguna->id }}', 'role_id', '{{ $pengguna->getRoleNames()->first() }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $pengguna->getRoleNames()->first() ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($editFieldRowId == $pengguna->id . '-password')
                                            <div class="d-flex justify-content-center">
                                                <input type="text" class="form-control form-control-sm" wire:blur="ubah('{{ $pengguna->id }}', 'password', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $pengguna->id }}', 'password', $event.target.value)" value=""
                                                    placeholder="Masukkan password baru..." @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div>
                                                <button type="button" class="btn btn-sm btn-primary rounded-1"
                                                    wire:click="editRow('{{ $pengguna->id }}', 'password', '{{ $pengguna->password }}')">
                                                    <strong>Reset</strong>
                                                </button>
                                            </div>
                                        @endif


                                    </td>
                                    @can('d_' . Request::segment(1))
                                        <td>
                                            <div>
                                                <button onclick="konfirmasiHapus({{ $pengguna->id }}, '{{ $pengguna->name }}')" type="button"
                                                    class="btn btn-sm btn-danger rounded-1"> <strong>Hapus</strong>
                                                </button>
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="avatarModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Pilih Avatar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @foreach ($avatars as $avatar)
                            <img wire:click="ubahAvatar('{{ $avatar }}')" src="{{ asset('img/avatars/' . $avatar) }}" alt="avatar-{{ $avatar }}"
                                class="rounded-circle border border-2 p-1 avatar-option" style="width:60px; cursor:pointer">
                        @endforeach
                        <span class="upload-plus avatar-option rounded-circle border border-2 bg-primary mt-2"
                            style="display:inline-block; width:60px; height:60px; line-height:53px; text-align:center; cursor:pointer;"
                            onclick="document.getElementById('customAvatar').click()">
                            <i class="bx bx-plus fs-3 text-white" style="vertical-align:middle"></i>
                        </span>
                        <input type="file" id="customAvatar" wire:model="customAvatar" accept="image/*" hidden>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@push('js')
    <script>
        document.addEventListener('show.bs.modal', function(e) {
            $('.modal-backdrop').remove();
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

            window.Livewire.on('close_modal', function(message) {
                $('#avatarModal').modal('hide');
            });
        });


        function simpanPengguna() {
            Livewire.dispatch('simpanPengguna');
        }


        function konfirmasiHapus(id, pengguna) {
            Swal.fire({
                title: 'Konfirmasi hapus',
                text: "Anda yakin ingin menghapus " + pengguna + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('hapusPengguna', {
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
                        title: pengguna + " telah dihapus."
                    });
                }
            });
        }
    </script>
@endpush
