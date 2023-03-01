<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->string('id')->primary()->autoIncrement()->change();
            // $table->id()->change();
            $table->unsignedBigInteger('admin_id')->change();
            $table->foreign('admin_id')->references('id')->on('admins')->onUpdate('CASCADE')->onDelete('CASCADE')->change();
            $table->string('filename')->change();
            $table->integer('price')->change();
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent()->change();
            $table->timestamp('updated_at')->useCurrent()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            //
        });
    }
}
