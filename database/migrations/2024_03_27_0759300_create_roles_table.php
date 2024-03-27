<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->timestamps();
        });

        Role::create([
            'role' => 'admin'
        ]);

        Role::create([
            'role' => 'patient'
        ]);

        Role::create([
            'role' => 'doctor'
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
