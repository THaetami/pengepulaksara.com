<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sastras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->string('slug');
            $table->string('penulis');
            $table->string('title');
            $table->text('body');
            $table->boolean('is_delete')->default(false)->nullable(false);
            $table->timestamp('publish_at')->nullable();
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
        Schema::dropIfExists('sastras');
    }
};
