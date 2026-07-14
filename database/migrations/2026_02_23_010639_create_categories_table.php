<?php

use App\Enums\ActivityStatus;
use App\Enums\CategoryTypes;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('image')->nullable();

            $table->tinyInteger('type')
                ->default(CategoryTypes::SERVICE->value)
                ->comment('1=Service , 2=Blog');

            $table->tinyInteger('activity_status')
                ->default(ActivityStatus::ACTIVE->value)
                ->comment('1 For Active , 2 For InActive');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
