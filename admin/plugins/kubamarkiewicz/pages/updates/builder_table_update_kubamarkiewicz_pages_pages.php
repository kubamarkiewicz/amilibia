<?php namespace KubaMarkiewicz\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczPagesPages extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->boolean('published')->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->boolean('published')->default(null)->change();
        });
    }
}
