<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once "config.php";

Capsule::schema()->dropIfExists('products');

Capsule::schema()->create('products', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->integer('category_id')->unsigned();
    $table->decimal('price')->unsigned();
    $table->string('photo_file');
    $table->string('description');
    $table->timestamps(); //created_at&updated_at тип datetime
});
//=========================
