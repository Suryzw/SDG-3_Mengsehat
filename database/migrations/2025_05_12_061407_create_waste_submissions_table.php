<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('waste_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('waste_category_id')->constrained('waste_categories')->onDelete('cascade');
            $table->float('weight');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->integer('total_point')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('waste_submissions');
    }
};
