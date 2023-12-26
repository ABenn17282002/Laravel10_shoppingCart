<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品カテゴリー情報一覧
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 mx-auto">
                            {{-- flassmessageの表示 --}}
                            <x-flash-message />
                            {{-- 新規作成ボタン --}}
                            <div class="flex justify-end mb-4">
                                <button onclick="location.href='{{ route('admin.categories.create')}}'"  class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                            </div>
                            {{-- カテゴリー情報はあるかの確認 --}}
                            @if (count($primaryCategories) > 0)
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Sort_Order</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">PrimaryCategory名</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Subcategory数</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($primaryCategories as $primaryCategory)
                                        <tr>
                                            <td class="md:px-4 py-3">{{ $primaryCategory->sort_order }}</td>
                                            <td class="md:px-4 py-3">{{ $primaryCategory->name }}</td>
                                            <td class="md:px-4 py-3">{{ $primaryCategory->secondary_count}}</td>
                                            <td class="md:px-4 py-3">
                                                <button onclick="location.href='{{ route('admin.categories.edit', $primaryCategory) }}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded ">編集</button>
                                            </td>
                                            <form id="delete_{{ $primaryCategory->id }}" method="post" action="{{ route('admin.categories.trash', $primaryCategory->id) }}">
                                                @csrf
                                                {{-- 削除メソッド --}}
                                                @method('delete')
                                                <td class="md:px-4 py-3">
                                                    <a href="#" data-id="{{ $primaryCategory->id }}" onclick="deletePost(this)"><img class="w-8 h-8" src="{{ asset("images/trash.png") }}"></a>
                                                </td>
                                            </form>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            @else
                                <p class="text-center">カテゴリー情報はありません。<br>カテゴリー情報を作成してください。</p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    {{-- 削除確認用アラート --}}
    <script>
        function deletePost(e) {
        'use strict';
        if (confirm('この情報をゴミ箱へ移します。宜しいですか？')) {
        document.getElementById('delete_' + e.dataset.id).submit();
        }
        }
    </script>
</x-app-layout>
