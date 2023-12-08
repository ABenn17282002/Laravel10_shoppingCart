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
                                <button onclick="" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                            </div>
                            {{-- カテゴリー情報はあるかの確認 --}}
                            @if (count($primaryCategories) > 0)
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">PrimaryCategory名</th>
                                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Subcategory数</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- 配列でデータベースで取得したものを１つずつ取得 --}}
                                        @foreach ($primaryCategories as $primaryCategory)
                                        <tr>
                                            <td class="md:px-4 py-3">{{ $primaryCategory->name }}</td>
                                            <td class="md:px-4 py-3"><a href="{{ route('admin.categories.show', $primaryCategory) }}">{{ $primaryCategory->secondary_count}}<a></td>
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

</x-app-layout>
