<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); // Oracle-friendly auto-increment
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('branch_id');
            $table->unsignedBigInteger('departament_id');
            
            $table->string('name');
            $table->string('cpf', 12)->unique(); 
            $table->string('phone_number', 15);
            $table->integer('is_admin')->default(0);
            
            
            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->string('email')->unique();
            $table->integer('status')->default(0)->comment('0 - Não aprovado | 1 - Aprovado com vínculo | 2 - Aprovado SEM vínculo | 3 - REPROVADO | 4 - INACTIVE = DELETED_AT ');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->string('message_validate')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('departament_id')->references('id')->on('departaments')->onDelete('cascade');
        });

        DB::table('users')->insert([
            'name' => 'Knapp Admin',
            'cpf' => '00000000000',
            'phone_number' => '11999999999',
            'is_admin' => 1,
            'company_id' => 1,
            'branch_id' => 1,
            'departament_id' => 1,  
            'uf' => 'PR',
            'endereco_detail' => 'Rua Afonso Pena',
            'email' => 'knapp_admin@knapp.com',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('senha123'), 
            'remember_token' => null,
            'message_validate' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
