<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name');
            $table->string('cnpj', 14)->unique();
            $table->string('phone_number', 15);
            $table->string('email')->unique();
            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->tinyInteger('status')->default(1); // 1 = ativo, 0 = inativo
            $table->timestamps();
            $table->softDeletes();

            // Definição da FK
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
