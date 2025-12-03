<?php

namespace App\Livewire\Backend;

use App\Models\User as ModelUser;
use App\Services\KeycloakService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Spatie\Permission\Models\Role as ModelRole;
class User extends Component
{
    use WithFileUploads;

    public $editFieldRowId, $customAvatar, $avatarBaru, $selectedUserId;
    public $modeTambah = false;
    public $index, $fallback, $avatars, $name, $email, $role;

    public bool $tampil_tambah = false;

    protected $rules = [
        'name' => 'required',
        'role' => 'required',
        'customAvatar' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'name.required' => 'Harus diisi.',
        'role.required' => 'Pilih role.',
        'customAvatar.image' => 'File harus berupa gambar (jpeg, png, dll).',
        'customAvatar.max' => 'Ukuran gambar maksimal 2 MB.',
    ];

    public function mount()
    {
        $this->fallback = class_basename(ModelUser::class);
        for ($i = 0; $i <= 9; $i++) {
            $this->avatars[] = $i . '.png';
        }
    }

    public function render()
    {
        $data = [];
        if (auth()->user()->hasRole('admin')) {
            $data['avatars'] = $this->avatars;
            $data['fallback'] = $this->fallback;
            $data['penggunas'] = ModelUser::all();
            $data['roles'] = ModelRole::all();
        }
        elseif (auth()->user()->hasRole('user')) {
            $data['avatars']  = $this->avatars;
            $data['fallback'] = $this->fallback;
            $data['penggunas'] = ModelUser::where('id', auth()->id())->get();
            $data['roles'] = auth()->user()->roles;
        }

        return view('livewire.backend.user', $data);

    }

    public function tambah()
    {
        $this->tampil_tambah = !$this->tampil_tambah;
        $this->index = ModelUser::count() + 1;
    }

    public function selectUser($id)
    {
        $this->selectedUserId = $id;
        $this->modeTambah = false;
    }

    public function ubah($id, $field, $value,KeycloakService $keycloak)
    {
        $data = ModelUser::findOrFail($id);

        if ($field === 'password') {
            $data->update([
                'password' => Hash::make($value),
            ]);
            $this->dispatch('toast_success', 'Password berhasil diubah');
        } elseif ($field === 'role') {
            $data->syncRoles([$value]);
            $this->dispatch('toast_success', $this->name . ' berhasil diubah');
        } else {
            $data->update([
                $field => $value,
            ]);
            if (in_array($field, ['name', 'email']) && $data->keycloak_id) {
                $keycloakData = [];
                if ($field === 'name') {
                    $keycloakData['firstName'] = $value;
                }
                if ($field === 'email') {
                    $keycloakData['email'] = $value;
                }
                $name = $data->name; // misal "Zulfahmi Ramadhani"

                // Pisahkan berdasarkan spasi
                $parts = explode(' ', $name);

                // Ambil last word sebagai lastName
                $lastName = array_pop($parts);

                // Sisanya gabungkan sebagai firstName
                $firstName = implode(' ', $parts);

                // Jika hanya satu kata, firstName tetap isi nama, lastName kosong
                if (empty($firstName)) {
                    $firstName = $lastName;
                    $lastName = '';
                }

                // Update Keycloak
                $keycloak->updateUser($data->keycloak_id, [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'enabled' => true, // jangan lupa
                ]);
                // $keycloak->updateUser($data->keycloak_id, $keycloakData);
            }

            $this->dispatch('toast_success', $this->name . ' berhasil diubah');
            $this->reset(['tampil_tambah', 'name']);
        }

        $this->editFieldRowId = null;
    }

    public function ubahAvatar($avatar)
    {
        if ($this->selectedUserId) {
            $data = ModelUser::find($this->selectedUserId);
            $data->update([
                'avatar' => $avatar,
            ]);
        } else {
            $this->avatarBaru = $avatar;
            $this->dispatch('close_modal');
            return;
        }

        $this->dispatch('toast_success', 'Avatar berhasil diubah.');
        $this->dispatch('close_modal');
    }

    public function updatedCustomAvatar()
    {
        $this->validateOnly('customAvatar');

        if ($this->selectedUserId) {
            $data = ModelUser::find($this->selectedUserId);

            $filename = 'custom-' . $data->name . '.' . $this->customAvatar->getClientOriginalExtension();
            $this->customAvatar->storeAs('img/avatars/' . $data->name, $filename, 'public');
            $data->update([
                'avatar' => $filename,
            ]);
        } else {
            $filename = 'custom-avatar' . (ModelUser::count() + 1) . '.' . $this->customAvatar->getClientOriginalExtension();
            $this->customAvatar->storeAs('img/avatars/avatar/', $filename, 'public');
            $this->avatarBaru = $filename;
        }

        $this->dispatch('toast_success', 'Avatar berhasil diubah.');
        $this->dispatch('close_modal');
    }

    public function editRow($id, $field, $value)
    {
        $this->editFieldRowId = $id . '-' . $field;

        if ($field === 'name') {
            $this->name = $value;
        }
    }

    #[On('simpanPengguna')]
    public function simpan()
    {
        $this->validate();

        // Default avatar
        $avatarName = $this->avatarBaru ?? '0.png';

        // Jika $this->avatarBaru mengandung kata 'avatar', ganti menjadi custom-namaUser.ext
        if ($this->avatarBaru && Str::contains($this->avatarBaru, 'avatar')) {
            $avatarName = 'custom-' . $this->name . '.' . $this->customAvatar->getClientOriginalExtension();

            // Simpan file ke storage/public/img/avatars/namaUser/
            $this->customAvatar->storeAs('public/img/avatars/' . $this->name, $avatarName);
        }


        // Buat user baru
        $user = ModelUser::create([
            'avatar' => $avatarName,
            'name' => $this->name,
            'password' => Hash::make($this->name),
            'id_role' => $this->role,
        ]);

        // Assign Spatie role to the created user (role is stored as name in select)
        if ($this->role) {
            $user->assignRole($this->role);
        }

        $this->dispatch('toast_success', 'User ' . $this->name . ' berhasil ditambahkan.');

        // Reset form dan tutup modal
        $this->reset(['tampil_tambah', 'name', 'role', 'avatarBaru', 'customAvatar']);
    }

    #[On('hapusPengguna')]
    public function hapus($id)
    {
        $user = ModelUser::findOrFail($id);
        $name = $user->name;
        $user->delete();
        $this->dispatch('toast_success', 'User ' . $name . ' berhasil dihapus.');
    }
}
