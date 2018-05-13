<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAmilibiaAmilibiaProducts extends Migration
{
    public function up()
    {
        Schema::create('amilibia_amilibia_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('sort_order');
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('amilibia_amilibia_products');
    }
}
