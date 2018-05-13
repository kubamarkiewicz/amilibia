<?php namespace KubaMarkiewicz\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczPagesPages2 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->renameColumn('url', 'slug');
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->renameColumn('slug', 'url');
        });
    }
}
