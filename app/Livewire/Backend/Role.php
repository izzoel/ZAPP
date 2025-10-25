<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Spatie\Permission\Models\Role as ModelRole;

class Role extends Component
{
    public $editFieldRowId;
    public $index, $role;

    public bool $tampil_tambah = false;

    protected $rules = [
        'role' => 'required',
    ];

    protected $messages = [
        'role.required' => 'Harus diisi.',
    ];

    public function render()
    {
        $data['roles'] = ModelRole::all();
        $data['fallback'] = class_basename(Role::class);

        return view('livewire.backend.role', $data);
    }

    public function tambah()
    {
        $this->tampil_tambah = !$this->tampil_tambah;
        $this->index = ModelRole::count() + 1;
    }

    public function ubah($id, $field, $value)
    {
        $data = ModelRole::find($id);

        if (!$data) {
            return;
        }

        // Map UI 'role' field to Spatie Role's 'name' attribute
        $dbField = $field === 'role' ? 'name' : $field;

        $data->update([
            $dbField => $value,
        ]);

        $this->editFieldRowId = null;

        // Use the new value for role changes, otherwise use the role's name
        $displayName = $field === 'role' ? $value : $data->name;
        $this->dispatch('toast_success', $displayName . ' berhasil diubah.');
        $this->reset(['tampil_tambah', 'role']);
    }

    public function editRow($id, $field, $value)
    {
        $this->editFieldRowId = $id . '-' . $field;

        if ($field === 'role') {
            $this->role = $value;
        }
    }

    #[On('simpanRole')]
    public function simpan()
    {
        $this->validate();
        // Create using Spatie Role's 'name' column
        ModelRole::create([
            'name' => $this->role,
        ]);

        $this->dispatch('toast_success', 'Role ' . $this->role . ' berhasil ditambahkan.');
        $this->reset(['tampil_tambah', 'role']);
    }

    #[On('hapusRole')]
    public function hapus($id)
    {
        // Capture the role name before deleting so we can show it in the message
        $role = ModelRole::findOrFail($id);
        $name = $role->name;
        $role->delete();
        $this->dispatch('toast_success', 'Role ' . $name . ' berhasil dihapus.');
    }
}
