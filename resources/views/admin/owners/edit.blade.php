<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー情報編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font relative">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">オーナー登録</h1>
                            </div>
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                {{-- オーナー情報の編集--}}
                                {{-- ownerメソッドよりidを取得:/index 名前付きルート 第2引数にidを指定 --}}
                                <form method="post" action="{{ route('admin.owners.update',['owner'=> $owner -> id]) }}">
                                    {{-- 編集→更新する場合はPUTメソッドを使用する。 --}}
                                    @method('PUT')
                                    @csrf
                                    <div class="-m-2">
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                                <label for="name" class="leading-7 text-sm text-gray-600">オーナー名</label>
                                                {{-- データベースより情報取得 --}}
                                                <input type="text" id="name" name="name" value="{{ $owner ->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                                <input type="email" id="email" name="email" value="{{ $owner -> email }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        {{-- 店舗名 --}}
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <label for="shop_name" class="leading-7 text-sm text-gray-600">店舗名</label>
                                                {{-- ownertalbeに紐づいたshop_tableにある店舗名を取得 --}}
                                                <input type="text" id="shop_name" name="shop_name" value="{{ $owner->shop->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                                                <input type="password" id="password" name="password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-1/2 mx-auto">
                                            <div class="relative">
                                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード確認</label>
                                                {{-- PWを空白許可 --}}
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full flex justify-around mt-4">
                                            <button type="button" onclick="location.href='{{ route('admin.owners.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
                                        </div>
                                    </div>
                                </form>
                                {{-- オーナー情報編集ここまで --}}
                            </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
