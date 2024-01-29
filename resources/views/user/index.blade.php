<x-app-layout>
<x-slot name="header">
        <div class="flex justify-end">
            {{-- user用認証処理 --}}
            @if (Route::has('user.login'))
                <div class="sm:absolute sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth('users')
                    @else
                        <a href="{{ route('user.items.memberIndex')  }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ログイン</a>
                        @if (Route::has('user.register'))
                            <a href="{{ route('user.register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">会員登録</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品一覧画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-wrap">
                        @foreach($products as $product)
                            <div class="w-1/4 p-2 md:p-4">
                                @if (Auth::guard('users')->check())
                                    <a href="{{ route('user.items.membershow', ['item' => $product->id]) }}">
                                @else
                                    <a href="{{ route('user.items.show', ['item' => $product->id]) }}">
                                @endif
                                        <x-thumbnail filename="{{ $product->filename ?? ''}}" type="products" />
                                        {{-- 引用元:https://tailblocks.cc/ [Ecommerce] --}}
                                        <div class="mt-4">
                                            {{-- カテゴリー名 --}}
                                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category }}</h3>
                                            {{-- 製品名 --}}
                                            <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                            {{-- 価格(カンマを表示)--}}
                                            <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円(税込)</span></p>
                                        </div>
                                    </a>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ページネーション --}}
    {{ $products->links() }}
</x-app-layout>
