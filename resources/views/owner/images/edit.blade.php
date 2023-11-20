<x-app-layout>
    {{-- Owner/image/create.blade.php引用、一部変更 --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            画像情報編集画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Error_message --}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    {{-- 画像編集,imageId取得--}}
                    <form method="post" action="{{ route('owner.images.update', ['image' => $image->id ])}}" enctype="multipart/form-data">
                            @csrf
                            {{-- 一部編集の際はPUTMethod使用 --}}
                            @method('PUT')
                            <div class="-m-2">
                                {{-- 画像タイトル --}}
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">画像タイトル</label>
                                        <input type="text" id="title" name="title" value="{{ $image->title }}"class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    </div>
                                </div>
                                {{-- 画像のサムネイル --}}
                                <div class="p-2 w-1/2 mx-auto">
                                    <div class="relative">
                                        <label for="title" class="leading-7 text-sm text-gray-600">サムネイル画像</label>
                                        <x-thumbnail :filename="$image->filename" type="products" />
                                    </div>
                                </div>
                                <div class="p-2 w-full flex justify-around mt-4">
                                        {{-- 戻る --}}
                                        <button type="button" onclick="location.href='{{ route('owner.images.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                        {{-- 登録ボタン --}}
                                        <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
