<?php namespace KubaMarkiewicz\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczPagesPages7 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->text('content');
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_pages_pages', function($table)
        {
            $table->dropColumn('content');
        });
    }
}