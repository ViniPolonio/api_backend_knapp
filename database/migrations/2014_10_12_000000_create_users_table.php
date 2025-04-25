<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); // Oracle-friendly auto-increment

            $table->string('name');
            $table->string('cpf', 12)->unique(); 
            $table->string('phone_number', 15);
            $table->integer('is_admin')->default(0);

            $table->unsignedInteger('company_id');
            $table->unsignedInteger('branch_id');

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->string('uf', 2);
            $table->string('endereco_detail', 255);
            $table->string('email')->unique();
            $table->integer('status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
