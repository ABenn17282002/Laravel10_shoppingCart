<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート情報
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- flassmessageの表示 --}}
            <x-flash-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- カートに商品があるか --}}
                    @if (count($products) > 0)
                        {{-- あれば一つずつ取得する  --}}
                        @foreach ($products as $product )
                            <div class="md:flex md:items-center mb-2">
                                <div class="md:w-3/12">
                                    {{-- 商品画像 --}}
                                    @if ($product->imageFirst->filename !== null)
                                        <img src="{{ asset('storage/products/' . $product->imageFirst->filename )}}">
                                    @else
                                        <img src="">
                                    @endif
                                </div>
                                {{-- 商品名 --}}
                                <div class="md:w-4/12 md:ml-2">{{ $product->name }}</div>
                                <div class="md:w-3/12 flex justify-around">
                                    {{-- 個数 --}}
                                    <div>{{ $product->pivot->quantity }}個</div>
                                    {{-- 商品ごとの金額 --}}
                                    <div>{{ number_format($product->pivot->quantity * $product->price )}}<span class="text-sm text-gray-700">円(税込)</span></div>
                                </div>
                                <div class="md:w-2/12">
                                    <form id="delete_{{ $product->id }}" method="post" action="{{ route('user.cart.delete', ['item' => $product->id])}}">
                                        @csrf
                                        <a href="#" data-id="{{ $product->id  }}" onclick="deletePost(this)" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        {{-- 総額表示 --}}
                        合計金額: {{ number_format($totalPrice) }}<span class="text-sm text-gray-700">円(税込)</span>
                    @else
                        カートに商品が入っていません。
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- 削除確認用アラート --}}
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか?')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>