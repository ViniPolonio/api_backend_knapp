<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('cnpj', 16)->unique();
            $table->string('phone_number', 15);
            $table->string('email', 255)->unique();
            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->string('cep', 10);
            $table->smallInteger('status')->default(1)->comment('1 = ativo | 0 = inativo');
            $table->timestamps();
            $table->softDeletes();
        });

        // Inserção de empresa padrão
        DB::table('companies')->insert([
            'name' => 'Knapp - central',
            'cnpj' => '12345678000199',
            'phone_number' => '1133334444',
            'email' => 'knapp@knapp.com',
            'uf' => 'PR',
            'endereco_detail' => 'Rua Afonso Pena',
            'cep' => '01234-567',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
