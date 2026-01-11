<?php

use App\Enums\CommentStatus;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId(column: 'parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->text('comment');
            $table->string('status')->default(CommentStatus::PENDING->value);
            $table->string('guest_name');
            $table->string('guest_email');
            // Meta
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->index(['post_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
