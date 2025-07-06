<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Links to the product being reviewed
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to the user who wrote the review
            $table->tinyInteger('rating')->unsigned(); // Stores the 1-5 star rating
            $table->text('feedback')->nullable(); // The text of the review/comment
            $table->string('image_path')->nullable(); // Path to an optional uploaded image for the review
            $table->timestamps(); // `created_at` and `updated_at` timestamps

            // Ensures a user can only submit one review per product
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
