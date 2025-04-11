<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE TABLE password_resets (
                email VARCHAR2(255) PRIMARY KEY,
                token VARCHAR2(255),
                created_at TIMESTAMP NULL
            )
        ");
    }

    public function down()
    {
        DB::statement("DROP TABLE password_resets CASCADE CONSTRAINTS");
    }
};
