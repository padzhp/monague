<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->integer('odering');
            $table->tinyInteger('status');
            $table->tinyInteger('ca_enabled');
            $table->tinyInteger('ca_published');            
            $table->string('ca_sku', 50);
            $table->decimal('ca_six_plus',8,2);
            $table->decimal('ca_six_pack',8,2);
            $table->decimal('ca_dozen_pack',8,2);
            $table->tinyInteger('us_enabled');
            $table->tinyInteger('us_published');            
            $table->string('us_sku', 50);
            $table->decimal('us_six_plus',8,2);
            $table->decimal('us_six_pack',8,2);
            $table->decimal('us_dozen_pack',8,2);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
