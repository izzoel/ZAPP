<?php

namespace App\Livewire\Backend;

use App\Models\Menu as ModelMenu;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission as ModelAkses;
use Spatie\Permission\Models\Role as ModelRole;

class Akses extends Component
{
    public $menus, $roles;
    public $permissions = [];
    public $selectedRolesPerMenu = [];
    public $create, $read, $update, $delete;

    public function mount()
    {
        $this->menus = ModelMenu::whereNotNull('parent_id')->get();
        $this->roles = ModelRole::all();

        foreach ($this->menus as $menu) {
            $this->selectedRolesPerMenu[$menu->id] = $this->roles->filter(fn($role) => $role->permissions->pluck('name')->contains(fn($p) => str_ends_with($p, "_{$menu->menu}")))->pluck('id')->toArray();
        }
    }

    public function render()
    {
        $menus = ModelMenu::whereNotNull('parent_id')->get();
        $roles = ModelRole::all();
        $fallback = class_basename(__CLASS__);

        return view('livewire.backend.akses', compact('menus', 'roles', 'fallback'));
    }

    public function saveRole($menuId, $roleIds)
    {
        $menu = ModelMenu::findOrFail($menuId);
        $permissions = ModelAkses::where('name', 'like', '%_' . strtolower($menu->menu))->get();

        #####

        $selectedRoles = $this->roles->whereIn('id', $roleIds);
        $rolesDebug = [];
        // foreach ($selectedRoles as $role) {
        //     $rolesDebug[] = [
        //         'role' => $role->name,
        //         'permissions' => $this->groupPermissions[$menuId][$role->id] ?? [
        //             'c' => false,
        //             'r' => false,
        //             'u' => false,
        //             'd' => false,
        //         ],
        //     ];
        // }

        foreach ($selectedRoles as $role) {
            // Ambil permission yang sudah ada untuk menu ini
            $currentPerms = $role->permissions->pluck('name')->intersect($permissions->pluck('name'))->toArray();

            // Jika role sudah punya semua permission menu, lakukan nothing
            if (count($currentPerms) === $permissions->count()) {
                continue; // tidak menambahkan apa pun
            }

            // Jika role belum punya permission, tambahkan permission yang belum ada
            $toAdd = array_diff($permissions->pluck('name')->toArray(), $currentPerms);
            if (!empty($toAdd)) {
                $role->givePermissionTo($toAdd);
            }

            // Jangan hapus permission sama sekali
            // Kita hanya menyinkronkan jika opsi dihapus atau ditambahkan, bukan ketika tidak ada perubahan
        }

        $debug = [
            'permission' => $currentPerms,
            // '+' => $toAdd,
        ];

        // dd($debug);
        ######

        $rolesWithPermission = $this->roles
            ->filter(function ($role) use ($permissions) {
                return $role->permissions->pluck('name')->intersect($permissions->pluck('name'))->isNotEmpty();
            })
            ->pluck('id')
            ->toArray();

        // $rolesWithPermission = $this->roles->map(function ($role) use ($permissions) {
        //     $rolePermissions = $role->permissions->pluck('name')->intersect($permissions->pluck('name'))->toArray();
        //     return [
        //         'role_id' => $role->id,
        //         'role_name' => $role->name,
        //         'permissions_for_menu' => $rolePermissions,
        //     ];
        // });

        $toAdd = array_diff($roleIds, $rolesWithPermission);

        foreach ($this->roles->whereIn('id', $toAdd) as $role) {
            $role->givePermissionTo($permissions);
        }

        $toRemove = array_diff($rolesWithPermission, $roleIds);
        foreach ($this->roles->whereIn('id', $toRemove) as $role) {
            $role->revokePermissionTo($permissions);
        }

        $this->dispatch('toast_success', 'Role berhasil diupdate!');
    }

    public function toggleGroupPermission($roleIds, $permissionName)
    {
        $code = explode('_', $permissionName)[0];
        $menu = explode('_', $permissionName)[1];

        $map = [
            'c' => 'Create',
            'r' => 'Read',
            'u' => 'Update',
            'd' => 'Delete',
        ];

        $akses = $map[$code] ?? $code;
        foreach ($roleIds as $roleId) {
            $role = ModelRole::find($roleId);
            if ($role->hasPermissionTo($permissionName)) {
                $role->revokePermissionTo($permissionName);
            } else {
                $role->givePermissionTo($permissionName);
            }
        }
        $this->dispatch('toast_success', "$akses $menu diperbarui");
    }

    public function groupRolesByPermissions($menu, $roles)
    {
        $groups = [];

        foreach ($roles as $role) {
            $perms = collect(['c', 'r', 'u', 'd'])
                ->mapWithKeys(function ($code) use ($role, $menu) {
                    $permName = $code . '_' . strtolower($menu->menu);
                    return [$code => $role->hasPermissionTo($permName)];
                })
                ->toArray();

            $hash = implode('-', array_map(fn($v) => $v ? 1 : 0, $perms));

            $groups[$hash]['permissions'] = $perms;
            $groups[$hash]['roles'][] = $role;
        }

        return array_values($groups);
    }
}
