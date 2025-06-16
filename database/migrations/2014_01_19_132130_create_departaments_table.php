<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\DepartamentSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departaments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->smallInteger('status')->default(1)->comment('1 = ativo | 0 = inativo');
            $table->timestamps();
            $table->softDeletes();
        });

        // Chama o seeder após a criação da tabela
        $this->callSeeder();
    }

    protected function callSeeder()
    {
        // Roda o seeder diretamente
        app()->make(DepartamentSeeder::class)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departaments');
    }
};
