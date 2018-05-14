<?php namespace KubaMarkiewicz\Translations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateKubamarkiewiczTranslationsTranslations11 extends Migration
{
    public function up()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->text('translation')->nullable();
            $table->text('translation_json')->nullable();
            $table->dropColumn('content');
            $table->dropColumn('kuba');
        });
    }
    
    public function down()
    {
        Schema::table('kubamarkiewicz_translations_translations', function($table)
        {
            $table->dropColumn('translation');
            $table->dropColumn('translation_json');
            $table->text('content')->nullable();
            $table->text('kuba')->nullable();
        });
    }
}