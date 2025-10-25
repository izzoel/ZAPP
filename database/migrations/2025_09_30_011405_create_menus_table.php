<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan')->default(0);
            $table->string('menu');
            $table->string('segment')->nullable();
            $table->string('icon')->nullable();
            $table->string('permission_view')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('menus')->insert([
            'id' => 1,
            'urutan' => 0,
            'menu' => 'Setting',
            'segment' => 'setting',
            'icon' => null,
            'permission_view' => null,
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('menus')->insert([
            [
                'id' => 2,
                'urutan' => 0,
                'menu' => 'Akses',
                'segment' => 'akses',
                'icon' => 'bx-lock-open',
                'permission_view' => null,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'urutan' => 0,
                'menu' => 'Menu',
                'segment' => 'menu',
                'icon' => 'bx-menu',
                'permission_view' => null,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'urutan' => 0,
                'menu' => 'Role',
                'segment' => 'role',
                'icon' => 'bx-cog',
                'permission_view' => null,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'urutan' => 0,
                'menu' => 'User',
                'segment' => 'user',
                'icon' => 'bx-camera-portrait',
                'permission_view' => null,
                'parent_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
