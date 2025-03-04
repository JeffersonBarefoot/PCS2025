<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name');
            $table->boolean('personal_team');
            $table->timestamps();
            $table->string('Level1Desc',50)->default('Location');
            $table->string('Level2Desc',50)->default('Department');
            $table->string('Level3Desc',50)->default('...not used...');
            $table->string('Level4Desc',50)->default('...not used...');
            $table->string('Level5Desc',50)->default('...not used...');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
