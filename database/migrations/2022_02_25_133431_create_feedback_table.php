<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained('workouts');
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->string('workout_name');
            $table->string('exercise_name');
            $table->integer('original_series');
            $table->integer('original_repetitions');
            $table->double('original_weight')->nullable();
            $table->string('original_add_info')->nullable();
            $table->string('original_notes')->nullable();
            $table->string('actual_series')->nullable();
            $table->string('actual_repetitions')->nullable();
            $table->double('actual_weight')->nullable();
            $table->enum('feedback_rating',['less','ok','more'])->default('ok');
            $table->string('feedback_notes')->nullable();
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
        Schema::dropIfExists('feedback');
    }
}
