<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->string('name', 255);
            $table->string('cnpj', 14)->unique();
            $table->string('phone_number', 15);
            $table->string('email', 255)->unique();
            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->smallInteger('status')->default(1)->comment('1 = ativo, 0 = inativo');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
