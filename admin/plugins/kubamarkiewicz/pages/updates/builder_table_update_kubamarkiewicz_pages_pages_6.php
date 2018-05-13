<?php namespace KubaMarkiewicz\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczPagesPages6 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->integer('sort_order');
        });
    }
}
