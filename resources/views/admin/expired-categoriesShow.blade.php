<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            削除済み商品カテゴリー情報詳細
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-10 mx-auto">
                            {{-- プライマリーカテゴリー情報表示 --}}
                            <label class="text-sm text-gray-600 font-semibold">プライマリーカテゴリー情報</label>
                            <div class="mb-4 flex">
                                {{-- Primary Category sort_order --}}
                                <div class="w-1/6">
                                    <label for="primary_sort_order" class="text-sm text-gray-600">ソート順</label>
                                    <p id="primary_sort_order" class="w-full bg-gray-100 rounded border border-gray-300">{{ $primaryCategory->sort_order }}</p>
                                </div>
                                {{-- Primary Category name --}}
                                <div class="w-5/6 mr-4">
                                    <label for="primary_name" class="text-sm text-gray-600">カテゴリー名</label>
                                    <P id="primary_name" class="w-full bg-gray-100 rounded border border-gray-300">{{ $primaryCategory->name }}</P>
                                </div>
                            </div>
                            {{-- 既存のセカンダリーカテゴリー情報表示 --}}
                            <label class="text-sm text-gray-600 font-semibold">セカンダリーカテゴリー情報</label>
                            <div class="overflow-x-auto mb-20">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-800 text-white">
                                        <tr>
                                            <th class="w-2/12 py-3 px-4 text-left">順序</th>
                                            <th class="w-10/12 py-3 px-4 text-left">カテゴリー名</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @forelse ($expiredSecondaryCategories as $secondaryCategory)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $secondaryCategory->sort_order }}</td>
                                            <td class="border px-4 py-2">{{ $secondaryCategory->name }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-left py-4">登録済みセカンダリーカテゴリ情報はありません。</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" onclick="location.href='{{ route('admin.expired-categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
