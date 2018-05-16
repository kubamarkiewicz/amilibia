<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAmilibiaAmilibiaWorks extends Migration
{
    public function up()
    {
        Schema::create('amilibia_amilibia_works', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('amilibia_amilibia_works');
    }
}
