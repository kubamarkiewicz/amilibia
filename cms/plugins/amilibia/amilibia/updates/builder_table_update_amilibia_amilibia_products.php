<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAmilibiaAmilibiaProducts extends Migration
{
    public function up()
    {
        Schema::table('amilibia_amilibia_products', function($table)
        {
            $table->boolean('published');
        });
    }
    
    public function down()
    {
        Schema::table('amilibia_amilibia_products', function($table)
        {
            $table->dropColumn('published');
        });
    }
}
