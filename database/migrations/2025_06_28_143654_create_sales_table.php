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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('product_name');
            $table->integer('qty');
            $table->decimal('price_per_unit', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('platform')->default('Shopee'); // Shopee, TikTok, dll
            $table->enum('status', ['selesai', 'batal', 'retur'])->default('selesai');
            $table->text('alasan_batal')->nullable();
            $table->text('alasan_retur')->nullable();
            $table->date('tanggal_retur')->nullable();
            $table->decimal('biaya_iklan', 12, 2)->default(0);
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->text('notes')->nullable();
            $table->date('sale_date');
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
        Schema::dropIfExists('sales');
    }
}; 