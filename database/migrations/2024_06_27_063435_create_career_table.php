<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('tckimlik_no');
            $table->string('ad');
            $table->string('soyad');
            $table->unsignedSmallInteger('dogum_yili');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->string('birth_place');
            $table->string('blood_type');
            $table->text('social_media');
            $table->text('address');
            $table->string('position');
            $table->string('marital_status');
            $table->string('driving_license');
            $table->text('note')->nullable();
            $table->json('education_details')->nullable();
            $table->json('work_details')->nullable();
            $table->json('reference_details')->nullable();
            $table->json('language_details')->nullable();
            $table->json('experience_details')->nullable();
            $table->string('criminal_record');
            $table->string('disability_situation');
            $table->string('travel_ban');
            $table->string('smoking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
