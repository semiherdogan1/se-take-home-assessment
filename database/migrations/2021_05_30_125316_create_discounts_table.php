<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->string('reason', 191);
            $table->enum('amount_operator', ['=', '<', '>', '>=', '<='])->nullable();
            $table->decimal('amount')->default(0);
            $table->decimal('discount')->default(0);
            $table->tinyInteger('discount_type')->default(0);
            $table->string('class', 191);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
