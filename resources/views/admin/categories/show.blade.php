<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Secondary Categories for {{ $primaryCategory->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-20 mx-auto">
                            <div class="-m-2">
                                <div class="lg:w-2/3  mx-auto overflow-auto mb-8">
                                        <div class="relative">
                                            {{-- カテゴリー情報はあるかの確認 --}}
                                            @if (count($secondaryCategories) > 0)
                                            <table class="text-left w-full border-collapse">
                                                <thead>
                                                    <tr>
                                                        <th class="py-4 px-6 font-bold text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                                        <th class="py-4 px-6 font-bold text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">カテゴリ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($secondaryCategories as $secondaryCategory)
                                                        <tr class="hover:bg-grey-lighter">
                                                            <td class="py-4 px-6 border-b border-grey-light">{{ $secondaryCategory->id }}</td>
                                                            <td class="py-4 px-6 border-b border-grey-light">{{ $secondaryCategory->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                            <p class="text-left">カテゴリー情報はありません。<br>カテゴリー情報を作成してください。</p>
                                        @endif
                                </div>
                                <div class="p-2 w-full flex justify-around mt-8">
                                    <button type="button" onclick="location.href='{{ route('admin.categories.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    <button onclick="" class="text-white bg-indigo-400 border-0 px-4 py-2 focus:outline-none hover:bg-indigo-500 rounded">編集する</button>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
