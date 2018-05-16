<?php namespace KubaMarkiewicz\Translations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczTranslationsTranslations9 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->renameColumn('translation', 'content');
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->renameColumn('content', 'translation');
        });
    }
}
