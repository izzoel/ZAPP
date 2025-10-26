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
                                <th class="col-auto text-start">Role</th>
                                <th class="col-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @if ($tampil_tambah)
                                <tr class="text-center" style="background-color: rgb(133 146 163 / 60%);">
                                    <td>{{ $index }}</td>
                                    <td class="text-start">
                                        <input wire:model="role" type="text"
                                            class="form-control form-control-md {{ $errors->has('role') ? 'is-invalid' : 'border border-secondary' }}" placeholder="role..">

                                        <div class="invalid-feedback">
                                            @error('role')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </td>

                                    <td>
                                        <button onclick="simpanRole()" type="button" class="btn btn-sm btn-primary rounded-1">
                                            <strong>Simpan</strong>
                                        </button>
                                    </td>
                                </tr>
                            @endif

                            @foreach ($roles as $role)
                                <tr class="text-center">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="text-start" x-data>
                                        @if ($editFieldRowId == $role->id . '-name')
                                            <div class="d-flex justify-content-center">
                                                <input wire:blur="ubah('{{ $role->id }}', 'name', $event.target.value)"
                                                    wire:keydown.enter="ubah('{{ $role->id }}', 'role', $event.target.value)" class="form-control form-control-sm"
                                                    value="{{ $role->name }}" @click.outside="$wire.set('editFieldRowId', null)" />
                                            </div>
                                        @else
                                            <div wire:click="editRow('{{ $role->id }}', 'name', '{{ $role->name }}')" class="edit-icon"
                                                style="cursor: pointer; position: relative;">
                                                {{ $role->name ?? '---' }}
                                                <i class="bx bx-edit-alt text-warning icon-hover"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button onclick="konfirmasiHapus({{ $role->id }}, '{{ $role->name }}')" type="button" class="btn btn-sm btn-danger rounded-1"
                                                @cannot('d_' . Request::segment(1))disabled @endcan><strong>Hapus</strong></button>
                                        </div>
                                    </td>
                                </tr>
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


        function simpanRole() {
            Livewire.dispatch('simpanRole');
        }


        function konfirmasiHapus(id, role) {
            Swal.fire({
                title: 'Konfirmasi hapus',
                text: "Anda yakin ingin menghapus " + role + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('hapusRole', {
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
                        title: role + " telah dihapus."
                    });
                }
            });
        }
    </script>
@endpush
