<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAmilibiaAmilibiaLocations extends Migration
{
    public function up()
    {
        Schema::create('amilibia_amilibia_locations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('published');
            $table->string('name');
            $table->text('details');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('amilibia_amilibia_locations');
    }
}
