<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('language')->nullable()->comment('语言');
            $table->longText('content')->comment('内容');
            $table->string('password')->nullable()->comment('密码');
            $table->integer('count_limit')->default('0')->comment('限制浏览次数');
            $table->integer('time_limit')->default('0')->comment('限制浏览时间');
            $table->tinyInteger('is_destroy')->default('0')->comment('是否可销毁 0不可销毁 1可销毁');
            $table->integer('user_id')->default('0')->comment('提交用户');
            $table->string('ip')->nullable()->comment('提交ip');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
