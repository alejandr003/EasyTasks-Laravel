<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('mensaje');
            $table->boolean('activo')->default(false);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('avisos');
    }
};
