<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 出品者
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('set null'); // 購入者
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('image')->nullable();
            $table->text('description');
            $table->unsignedInteger('price');
            $table->string('condition');
            $table->boolean('is_sold')->default(false);
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
        Schema::dropIfExists('products');
    }
}
