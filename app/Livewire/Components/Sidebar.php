<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Menu as ModelMenu;
class Sidebar extends Component
{
    public $visible = false;

    public function render()
    {
        $data['menus'] = ModelMenu::orderBy('urutan')->get();
        return view('livewire.components.sidebar', $data);
    }

    #[On('sidebar_reload')]
    public function reloadSidebar() {}

    #[On('showSidebar')]
    public function toggleSidebar()
    {
        $this->visible = !$this->visible;
        logger('[DEBUG] Sidebar visibility: ' . ($this->visible ? 'ON' : 'OFF'));
    }
}
