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
        Schema::table('containers', function (Blueprint $table) {
            $table->primary('uuid');
        });

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->integer('size');
            $table->string('mime_type', 126);
            $table->string('name', 256);
            $table->string('container_uuid', 36);
            $table->foreign('container_uuid')
                ->references('uuid')
                ->on('containers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::dropIfExists('files');
    }
};
