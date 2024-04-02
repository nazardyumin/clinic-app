<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Doctor;
use App\Models\Speciality;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            //$table->string('email')->unique();
            //$table->string('password');
            $table->string('name');
            $table->string('photo');
            $table->foreignIdFor(Speciality::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        $F_male = array("Иванов", "Петров", "Сидоров", "Михайлов", "Павлов", "Сергеев");
        $I_male = array("Андрей", "Станислав", "Алексей", "Степан", "Виктор", "Владимир");
        $O_male = array("Филиппович", "Денисович", "Олегович", "Петрович", "Антонович", "Владимирович");

        $F_fem = array("Жукова", "Долгова", "Зайцева", "Волкова", "Шишкина", "Медведева");
        $I_fem = array("Анна", "Надежда", "Ирина", "Екатерина", "Наталья", "Светлана");
        $O_fem = array("Леонидовна", "Валерьевна", "Вячеславовна", "Борисовна", "Дмитриевна", "Георгиевна");

        for ($i = 1; $i <= 10; $i++) {
            Doctor::create([
                'name' => $F_male[rand(0, count($F_male) - 1)] . " " . $I_male[rand(0, count($I_male) - 1)] . " " . $O_male[rand(0, count($O_male) - 1)],
                'photo' => 'images/docs/male' . $i . '.jpg',
                'speciality_id' => $i
            ]);
            Doctor::create([
                'name' => $F_fem[rand(0, count($F_fem) - 1)] . " " . $I_fem[rand(0, count($I_fem) - 1)] . " " . $O_fem[rand(0, count($O_fem) - 1)],
                'photo' => 'images/docs/female' . $i . '.jpg',
                'speciality_id' => $i
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
