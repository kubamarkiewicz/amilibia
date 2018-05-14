<?php namespace Amilibia\Amilibia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAmilibiaAmilibiaProducts2 extends Migration
{
    public function up()
    {
        Schema::table('amilibia_amilibia_products', function($table)
        {
            $table->text('slug');
        });
    }
    
    public function down()
    {
        Schema::table('amilibia_amilibia_products', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
