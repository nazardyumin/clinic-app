<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Doctor;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetable_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Doctor::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->integer('admin_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetable_logs');
    }
};
