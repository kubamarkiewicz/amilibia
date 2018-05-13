<?php namespace KubaMarkiewicz\Translations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczTranslationsTranslations10 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->text('kuba')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->dropColumn('kuba');
        });
    }
}
