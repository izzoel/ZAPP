<?php

namespace App\Livewire\Backend;

use App\Models\Akses as ModelAkses;
use App\Models\Menu as ModelMenu;
use App\Models\User as ModelUser;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Menu extends Component
{
    use WithPagination;
    public $permission_view;
    public $disabledDelete = false;
    public $editFieldRowId;
    public $semuaMenu;

    public bool $tampil_tambah = false;

    public $menu, $segment, $icon, $parent_id;
    public $urutan = 0;

    protected $rules = [
        'urutan' => 'nullable|integer',
        'menu' => 'required',
        'segment' => 'nullable|regex:/^[a-z0-9\/\_]*$/',
    ];

    protected $messages = [
        'urutan.integer' => 'Harus berupa angka.',
        'menu.required' => 'Harus diisi.',
        'segment.regex' => 'Hanya huruf kecil, angka, "/" dan "_" tanpa spasi.',
    ];

    public function mount()
    {
        $this->semuaMenu = ModelMenu::all();
    }

    public function render()
    {
        $data['menus'] = ModelMenu::with(['children' => function ($q) {
            $q->orderBy('urutan');
        },
        ])
        ->whereNull('parent_id')
        ->orderBy('urutan')
        ->get();
        $data['fallback'] = class_basename(ModelMenu::class);
        return view('livewire.backend.menu', $data);
    }

    #[On('simpanMenu')]
    public function simpan()
    {
        $this->validate();

        $namaSegment = Str::studly(Str::afterLast($this->segment, '/'));
        $folder =
        'Backend/' .
        collect(explode('/', $this->segment))
        ->slice(0, -1)
        ->map(fn($s) => Str::studly($s))
        ->implode('/');

        $segmentPath = $folder ? $folder . $namaSegment : $namaSegment;

        ModelMenu::create([
            'urutan' => $this->urutan ?? 0,
            'menu' => $this->menu,
            'segment' => $this->segment,
            'icon' => $this->icon,
            'parent_id' => $this->parent_id,
        ]);

        if (!empty($this->segment)) {
            $this->artisanLivewire($segmentPath);


        }
        $permissionCodes = ['c', 'r', 'u', 'd'];

        $permissionNames = collect($permissionCodes)
        ->map(fn ($code) => $code . '_' . Str::slug($this->segment, '_'))
        ->toArray();

        foreach ($permissionNames as $permName) {
            Permission::firstOrCreate([
                'name'       => $permName,
                'guard_name' => 'web',
            ]);
        }

        $this->dispatch('toast_success', 'Menu ' . $this->menu . ' berhasil ditambahkan.');
        $this->dispatch('sidebar_reload');
        $this->reset(['tampil_tambah', 'urutan', 'menu', 'segment', 'icon', 'parent_id']);
    }

    private function artisanLivewire($segmentPath)
    {
        $php = $this->directoryPhp();
        $process = new Process(
            [
                $php,
                base_path('artisan'),
                'make:livewire',
                $segmentPath
            ],
            base_path()
        );

        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException(
                "Gagal menjalankan make:livewire.\n" .
                "Exit Code: " . $process->getExitCode() . "\n" .
                "Output: " . $process->getOutput() . "\n" .
                "Error Output: " . $process->getErrorOutput()
            );
        }

        $routeFile = base_path('routes/web.php');
        $fileContents = File::get($routeFile);

        $routeUrl = '/' . Str::of($this->segment)->lower();
        $classPath = 'App\\Livewire\\' . str_replace('/', '\\', $segmentPath);
        $routeLine = "Route::get('{$routeUrl}', \\{$classPath}::class);";

        if (!Str::contains($fileContents, $routeLine)) {
            $search = "=Dynamic Routes=";
            $pos = strpos($fileContents, $search);
            $indent = Str::repeat(' ', 4);

            if ($pos !== false) {
                $insertPos = strpos($fileContents, "\n", $pos) + 1;
                $fileContents = substr_replace($fileContents, $indent.$routeLine . "\n", $insertPos, 0);

                File::put($routeFile, $fileContents);
            }
            else {
                File::append($routeFile, "\n" . $routeLine);
            }
        }

    }

    private function directoryPhp()
    {
        $candidates = [
            '/usr/bin/php',
            '/usr/local/bin/php',
            '/opt/homebrew/bin/php',
            exec('which php'),
        ];

        foreach ($candidates as $php) {
            if ($php && file_exists($php) && is_executable($php)) {
                return $php;
            }
        }

        throw new \RuntimeException("PHP CLI binary not found.");
    }


    #[On('hapusMenu')]
    public function hapus($id)
    {
        $menu = ModelMenu::findOrFail($id);
        $segment = $menu->segment;

        if (!empty($segment)) {
            $namaSegment = Str::studly(Str::afterLast($segment, '/'));
            $folder =
            'Backend/' .
            collect(explode('/', $segment))
            ->slice(0, -1)
            ->map(fn($s) => Str::studly($s))
            ->implode('/');

            $segmentPath = $folder ? $folder . $namaSegment : $namaSegment;

            $classPath = app_path('Livewire/' . $segmentPath . '.php');
            if (File::exists($classPath)) {
                File::delete($classPath);
            }

            $viewPath = resource_path('views/livewire/' . Str::of($segmentPath)->replace('\\', '/')->lower() . '.blade.php');
            if (File::exists($viewPath)) {
                File::delete($viewPath);
            }

            $routeFile = base_path('routes/web.php');
            $routeUrl = '/' . Str::of($segment)->lower();
            $routeClass = 'App\\Livewire\\' . str_replace('/', '\\', $segmentPath);
            $routeLine = "Route::get('{$routeUrl}', \\{$routeClass}::class);";
            if (File::exists($routeFile)) {
                $contents = File::get($routeFile);
                $escapedClass = preg_quote($routeClass, '/');
                $pattern = "/Route::get\('" . preg_quote($routeUrl, '/') . "',\s*\\\\?" . $escapedClass . '::class\);\s*/';
                $contents = preg_replace($pattern, '', $contents);
                File::put($routeFile, $contents);
            }
        }

        $menu->delete();

        $this->dispatch('toast_success', 'Menu ' . $this->menu . ' berhasil dihapus.');
        $this->dispatch('sidebar_reload');
    }

    public function ubah($id, $field, $value)
    {
        $data = ModelMenu::find($id);

        if (!$data) {
            return;
        }

        if ($field === 'parent_id') {
            $value = empty($value) ? null : $value;
        } elseif ($field === 'urutan') {
            $value = $value ?? 0;
        }

        $data->update([
            $field => $value,
        ]);

        if ($field === 'segment' && !empty($value)) {
            $namaSegment = Str::studly(Str::afterLast($value, '/'));
            $folder = collect(explode('/', $value))
            ->slice(0, -1)
            ->map(fn($s) => Str::studly($s))
            ->implode('/');

            $segmentPath = $folder ? $folder . '/' . $namaSegment : $namaSegment;

            $komponenPath = app_path("Livewire/Backend/{$segmentPath}.php");

            if (!file_exists($komponenPath)) {
                Artisan::call('make:livewire', [
                    'name' => 'Backend' . ($folder ? '/' . $folder : '') . '/' . $namaSegment,
                ]);
            }
        }

        $this->editFieldRowId = null;
        $this->reset(['tampil_tambah', 'urutan', 'menu', 'segment', 'icon', 'parent_id']);
        $this->dispatch('toast_success', 'Menu ' . $this->menu . ' berhasil diubah.');
        $this->dispatch('sidebar_reload');
    }

    public function editRow($id, $field, $value)
    {
        $this->editFieldRowId = $id . '-' . $field;

        if ($field === 'urutan') {
            $this->urutan = $value;
        } elseif ($field === 'menu') {
            $this->menu = $value;
        } elseif ($field === 'segment') {
            $this->segment = $value;
        } elseif ($field === 'icon') {
            $this->icon = $value;
        }
    }

    public function tambah()
    {
        $this->tampil_tambah = !$this->tampil_tambah;
    }



}
