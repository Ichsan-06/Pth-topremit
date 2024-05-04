<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id');
            $table->string('type'); // local / international
            $table->string('status'); //
            $table->unsignedBigInteger('receipt_id');
            $table->unsignedBigInteger('currency_id');
            $table->float('rate')->nullable()->default(0);
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->nullable()->default(0);
            $table->timestamp('transaction_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
