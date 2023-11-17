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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            // 外部キー制約(owner_idに紐づくもの)
            $table->foreignId('owner_id')
            ->constrained()
            // Delete時の対応で外部制約のため必要
            ->onUpdate('cascade')
            ->onDelete('cascade');
            // 画像
            $table->string('filename');
            // title:null可
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
