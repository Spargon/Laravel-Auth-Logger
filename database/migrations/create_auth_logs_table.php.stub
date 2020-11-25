<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthLogsTable extends Migration
{
    public function up()
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('authenticatable');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('logout_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_logs');
    }
}
