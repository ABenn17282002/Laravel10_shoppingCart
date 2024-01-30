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
                                        <select class="rounded mr-3 border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                            <option>SM</option>
                                            <option>M</option>
                                            <option>L</option>
                                            <option>XL</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- カートに入れる --}}
                                <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                            </div>
                            <div class="flex justify-end py-2 ">
                            <button onclick="goBack()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">戻る</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@vite(['resources/js/swiper.js'])
<script>
    function goBack() {
        window.history.back();
    }
    </script>
</x-app-layout>