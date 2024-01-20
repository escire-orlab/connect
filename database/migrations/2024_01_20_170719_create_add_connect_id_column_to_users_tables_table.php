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
        Schema::table('users', function (Blueprint $table) {
            $table->string('connect_origin')->nullable()->after('email'); // orlab, proyecto_azul, etc
            $table->string('connect_id')->nullable()->after('connect_origin');
            $table->boolean('connect_active')->default(false)->after('connect_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['connect_id', 'connect_origin', 'connect_active']);
        });
    }
};
