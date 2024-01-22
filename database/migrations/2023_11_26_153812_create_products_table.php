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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // shopID(外部制約)、shopid削除後/更新後→自動で更新・削除
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            // secondary_category_id(外部制約),Primaryは消さないためcascadeなし
            $table->foreignId('secondary_category_id')->constrained();
            // 商品名
            $table->string('name');
            // 情報
            $table->text('information');
            // 価格(unsignedInteger:整数のみ)
            $table->unsignedInteger('price');
            // 販売情報
            $table->boolean('is_selling');
            // ソート
            $table->integer('sort_order')->nullable();
            // image指定,null許可、カラム名と違うのでテーブル名を指定
            $table->foreignId('image1')
            ->nullable()
            ->constrained('images');
            $table->foreignId('image2')
            ->nullable()
            ->constrained('images');
            $table->foreignId('image3')
            ->nullable()
            ->constrained('images');
            $table->foreignId('image4')
            ->nullable()
            ->constrained('images');
            $table->timestamps();
            // 論理削除用テーブルを追加
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
