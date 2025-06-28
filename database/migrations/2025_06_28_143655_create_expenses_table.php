<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category'); // gaji, iklan, stok, operasional, dll
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->text('description');
            $table->string('payment_method')->nullable(); // cash, transfer, dll
            $table->text('notes')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
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
        Schema::dropIfExists('expenses');
    }
}; 