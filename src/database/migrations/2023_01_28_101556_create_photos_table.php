<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            // $table->string('id')->primary()->autoIncrement();
            $table->id();
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('filename');
            $table->integer('price');
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
