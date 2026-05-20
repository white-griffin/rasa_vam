<?php

use App\Enums\LoanStatuses;
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
        Schema::create('loan_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bank_id')->constrained('banks');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount',10,8);
            $table->decimal('interest',10,8);
            $table->unsignedBigInteger('price');
            $table->tinyInteger('activity_status')
                ->default(LoanStatuses::PENDING->value)
                ->comment('1 For Active , 2 For Pending , 3 For Sold, 4 For Cancel, 5 For Expired');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_ads');
    }
};
