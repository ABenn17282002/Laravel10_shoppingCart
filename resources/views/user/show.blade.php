<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品詳細
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:flex md:justify-around">
                        {{-- 商品画像 --}}
                        <div class="md:w-1/2">
                            <!-- Slider main container -->
                            <div class="swiper relative">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    {{-- 1stImage --}}
                                    <div class="swiper-slide">
                                        {{-- 画像があれば画像を表示 --}}
                                        @if ($product->imageFirst->filename !== null)
                                            <img src="{{ asset('storage/products/' . $product->imageFirst->filename )}}" class="object-contain w-full h-full">
                                        @else
                                            <img src="" class="object-contain w-full h-full">
                                        @endif
                                    </div>
                                    {{-- 2ndImage --}}
                                    <div class="swiper-slide">
                                        @if ($product->imageSecond->filename !== null)
                                            <img src="{{ asset('storage/products/' . $product->imageSecond->filename )}}" class="object-contain w-full h-full">
                                        @else
                                            <img src="" class="object-cover w-full h-full">
                                        @endif
                                    </div>
                                    {{-- 3rdImage --}}
                                    <div class="swiper-slide">
                                        @if ($product->imageThird->filename !== null)
                                            <img src="{{ asset('storage/products/' . $product->imageThird->filename )}}" class="object-contain w-full h-full">
                                        @else
                                            <img src="" class="object-cover w-full h-full">
                                        @endif
                                    </div>
                                    {{-- 4thImage --}}
                                    <div class="swiper-slide">
                                        @if ($product->imageFourth->filename !== null)
                                            <img src="{{ asset('storage/products/' . $product->imageFourth->filename )}}" class="object-contain w-full h-full">>
                                        @else
                                            <img src="" class="object-contain w-full h-full">
                                        @endif
                                    </div>
                                </div>
                                <!-- If we need pagination -->
                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-pagination absolute inset-0 flex justify-center items-end p-4"></div>
                            </div>
                        </div>
                        <div class="md:w-1/2 ml-4">
                            {{-- 商品カテゴリー --}}
                            <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name }}</h2>
                            {{-- 商品名 --}}
                            <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium">{{ $product->name }}</h1>
                            {{-- 商品情報 --}}
                            <p class="mb-4 leading-relaxed">{{ $product->information }}</p>
                            <div class="flex justify-around items-center">
                                {{-- 商品価格 --}}
                                <div>
                                    <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}</span><span class="text-sm text-gray-700">円(税込)</span>
                                </div>
                                {{-- 数量 --}}
                                <div class="flex ml-auto items-center">
                                    <span class="mr-3">数量</span>
                                    <div class="relative">
                                        <select  name="quantity" class="rounded mr-3 border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                            {{-- 数量の取得 --}}
                                            @for ($i = 1; $i <= $quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }} </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                {{-- カートに入れる --}}
                                <button onclick="addToCart({{ $product->id }})" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                            </div>
                            <div class="flex justify-end py-2">
                            <button onclick="goBack()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">戻る</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 店舗情報の表示 --}}
                <div class="border-t border-gray-400 my-8"></div>
                <div class="mb-4 text-center">この商品を販売しているショップ</div>
                {{-- 店舗名 --}}
                <div class="mb-4 text-center">{{ $product->shop->name}}</div>
                {{-- 店舗画像の表示 --}}
                <div class="mb-4 text-center">
                @if ($product->shop->filename !== null)
                    <img class="mx-auto w-40 h-40 object-cover rounded-full" src="{{ asset('storage/shops/' . $product->shop->filename )}}">
                @else
                        <img src="">
                @endif
                </div>
                <div class="mb-4 text-center">
                    <button data-micromodal-trigger="modal-1" href='javascript:;' type="button" class="text-white bg-gray-400 border-0 py-2 px-6 focus:outline-none hover:bg-gray-500 rounded">ショップの詳細を見る</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal-window --}}
    <div class="modal micromodal-slide " id="modal-1" aria-hidden="true">
        {{-- 重ね順の調整 --}}
        <div class="z-10 modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                        <h2 class="text-xl text-gray-700" id="modal-1-title">{{ $product->shop->name }}</h2>
                        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <p>{{ $product->shop->information }}</p>
                </main>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
                </footer>
            </div>
        </div>
    </div>
@vite(['resources/js/swiper.js'])
<!-- jQueryを読み込み -->
@vite(['resources/js/jquery-3.7.1.min.js'])
<script>
    // 商品一覧ページへ戻る
    function goBack() {
        window.history.back();
    }

    // カートへ追加する機能
    function addToCart(productId) {
        // ログインしているかどうかを確認
        @auth
            // ログインしている場合、カートに商品を追加するAjaxリクエストを送信
            $.ajax({
                url: '/cart/add', // カートに商品を追加するルートを指定
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    productId: productId,
                    quantity: $('select[name="quantity"]').val() // 選択された数量を取得
                },
                success: function(response) {
                    // カートにアイテムが追加された場合の処理
                    // 例えば、アイコンの表示を更新したり、成功メッセージを表示したりできます
                    console.log('成功:', response);
                },
                error: function(response) {
                    // エラー処理
                    console.log('エラー:', response);
                }
            });
        @else
            // ログインしていない場合、ログインページにリダイレクト
            window.location.href = '/login'; // ログインページのURLを指定
        @endauth
    }
</script>
</x-app-layout>
