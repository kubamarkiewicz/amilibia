<?php namespace KubaMarkiewicz\Pages\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateKubamarkiewiczPagesPages extends Migration
{
    public function up()
    {
        Schema::create('kubamarkiewicz_pages_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->boolean('published');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('meta_title');
            $table->text('meta_description');
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('kubamarkiewicz_pages_pages');
    }
}