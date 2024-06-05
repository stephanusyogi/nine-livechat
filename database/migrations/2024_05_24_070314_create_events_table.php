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
        Schema::create('events', function (Blueprint $table) {
            // General Start
            $table->uuid('id')->primary();
            $table->string('name');
            $table->date('date');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('file_barcode');
            $table->boolean('flag_expired')->default(false);
            $table->boolean('flag_started')->default(false);
            // General End

            // Videotron Start
            $table->enum('videotron_flag_background', ['image', 'color']);
            $table->string('videotron_background_image')->nullable();
            $table->string('videotron_color_code')->nullable();
            // Videotron End

            // Visitor Start
            $table->enum('visitor_flag_background', ['image', 'color']);
            $table->string('visitor_background_image')->nullable();
            $table->string('visitor_color_code')->nullable();
            // Visitor End

            // Buble Start
            $table->string('bubble_color_code_message_name');
            $table->string('bubble_color_code_message_time');
            $table->string('bubble_color_code_message_text');
            $table->string('bubble_color_code_message_background');
            // Buble End

            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
