<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id');
            $table->json('departaments_json');
            $table->string('name', 255);
            $table->string('cnpj', 14)->unique();
            $table->string('phone_number', 15);
            $table->string('email', 255)->unique();
            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->string('cep', 10);
            $table->smallInteger('status')->default(1)->comment('1 = ativo, 0 = inativo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        $departaments = [
            [
                'title' => 'Recursos Humanos',
                'description' => 'Gestão de pessoas, recrutamento, treinamento e benefícios.',
                'status' => 1,
            ],
            [
                'title' => 'Financeiro',
                'description' => 'Gerenciamento financeiro, pagamentos, orçamentos e controle de custos.',
                'status' => 1,
            ],
            [
                'title' => 'Tecnologia da Informação (TI)',
                'description' => 'Suporte técnico, desenvolvimento de sistemas, infraestrutura e segurança da informação.',
                'status' => 1,
            ],
        ];

        DB::table('branches')->insert([
            'company_id' => 1,
            'departaments_json' => json_encode($departaments, JSON_UNESCAPED_UNICODE),
            'name' => 'Filial Central',
            'cnpj' => '98765432000188',
            'phone_number' => '1144445555',
            'email' => 'filial@example.com',
            'uf' => 'SP',
            'endereco_detail' => 'Av. Central, 456',
            'cep' => '01234-890',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
