<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVocabulariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->string('vocabulary');
            $table->string('complexity');
            $table->string('form')->nullable(); // like verb, subject, adverb, adjective
            $table->string('field')->nullable(); // like technology, medical, business, marketting, finance ... etc
            $table->string('usage_count')->nullable();
            $table->string('success_count')->nullable();
            $table->string('failure_count')->nullable();
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
        Schema::dropIfExists('vocabularies');
    }
}
