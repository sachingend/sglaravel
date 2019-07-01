<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('blog_name', 255)->unique()->index();
            $table->string('blog_seo_string', 255)->unique();           
            $table->string('blog_short_desc', 255);           
            $table->text('blog_desc');            
            $table->boolean('status')->default(true)->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blogs');
    }

}
