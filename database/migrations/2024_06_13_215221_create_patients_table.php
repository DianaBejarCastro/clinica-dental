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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('identification_number'); // num_id
            $table->string('identification_type'); // type_id
            $table->string('gender'); // gender
            $table->date('date_of_birth'); // day_of_birth
            $table->string('address'); // address
            $table->string('phone'); // phone
            $table->string('image')->nullable(); // image
            $table->foreignId('center_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
