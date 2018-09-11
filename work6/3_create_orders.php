<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once "config.php";

Capsule::schema()->dropIfExists('orders');

Capsule::schema()->create('orders', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('product_id')->unsigned();
    $table->string('email');
    $table->timestamps(); //created_at&updated_at тип datetime
});
//=========================
