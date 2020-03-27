<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID
            $table->integer('studio_id'); // Studio ID
            $table->timestamps(); // Created at + Updated at timestamp
            $table->string('event_name'); // Event Name
            $table->dateTime('start_date'); // Start event date
            $table->dateTime('end_date'); // End Event date
            $table->date('start_recur')->nullable(); // Start Event Recur Date
            $table->date('end_recur')->nullable(); // End Event Recur Date
            $table->tinyInteger('all_day')->default(0); // All Day Event
            $table->string('author'); // Event Author
            $table->integer('author_id'); // Event Author
            $table->json('days_of_week'); // Days of week
            $table->text('description')->nullable(); // Event description
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
