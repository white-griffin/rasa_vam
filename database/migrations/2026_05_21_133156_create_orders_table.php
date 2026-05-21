<?php

use App\Enums\OrderStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('order_number')->unique();
            $table->string('orderable_type');
            $table->unsignedBigInteger('orderable_id');
            $table->tinyInteger('order_status')
                ->default(OrderStatuses::PENDING->value)
                ->comment('1 For Pending , 2 For Paid , 3 For Cancelled, 4 For Failed');
            $table->bigInteger('total_amount');
            $table->string('description')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
