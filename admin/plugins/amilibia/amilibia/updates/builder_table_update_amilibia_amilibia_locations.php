<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAmilibiaAmilibiaLocations extends Migration
{
    public function up()
    {
        Schema::table('amilibia_amilibia_locations', function($table)
        {
            $table->integer('top');
            $table->integer('left');
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('amilibia_amilibia_locations', function($table)
        {
            $table->dropColumn('top');
            $table->dropColumn('left');
            $table->increments('id')->unsigned()->change();
        });
    }
}
