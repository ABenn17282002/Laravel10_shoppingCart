<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            削除済み商品カテゴリー情報一覧
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 mx-auto">
                            <div class="flex justify-end mb-4">
                                <button type="button" onclick="location.href='{{ route('admin.categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            </div>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            {{-- カテゴリー情報はあるかの確認 --}}
                            @if (count($expiredCategories) > 0)
                            <div class="lg:w-full w-full mx-auto overflow-auto">
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
                                        @foreach ($expiredCategories as $primaryCategory)
                                        <tr>
                                            <form method="post" action="{{ route('admin.expired-categories.restore', ['category' => $primaryCategory->id ])}}">
                                                @csrf
                                                <td class="md:px-4 py-3"><input type="number" id="sort_order_{{ $primaryCategory->id }}" name="sort_order" value="{{ $primaryCategory->sort_order }}"  class="bg-gray-100 rounded border border-gray-300" required></td>
                                                <td class="md:px-4 py-3"><input type="text" id="name_{{ $primaryCategory->id }}" name="name" value="{{ $primaryCategory->name }}" class="bg-gray-100 rounded border border-gray-300" required></td>
                                                <td class="md:px-4 py-3"><a href="{{ route('admin.expired-categories.show', ['category' => $primaryCategory->id ] ) }}">{{ $primaryCategory->secondary_count}}</a></td>
                                                <td class="px-4 py-3">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-400 text-white rounded py-2 px-4">復元</button>
                                                </td>
                                            </form>
                                            <form id="delete_{{ $primaryCategory-> id }}" method="post" action="{{ route('admin.expired-categories.destroy', ['category' => $primaryCategory->id ])}}">
                                                @csrf
                                                {{-- 削除メソッド --}}
                                                <td class="md:px-4 py-3">
                                                    <a href="#" data-id="{{ $primaryCategory-> id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded ">削除</a>
                                                </td>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <p class="text-center">削除済みカテゴリー情報はありません。</p>
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
    if (confirm('データを完全削除しますか?')) {
    document.getElementById('delete_' + e.dataset.id).submit();
    }
    }
    </script>
</x-app-layout>
