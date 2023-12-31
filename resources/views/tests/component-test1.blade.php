<x-tests.app>
    {{-- view/component/tests/app.blade.php用header--}}
    <x-slot name="header">
        コンポーネントテスト1Heaeder
    </x-slot>
    {{-- view/component/tests/app.blade.php用コンポーネント--}}
    コンポーネントテスト1

    {{-- cardへ値を受け渡しをするコンポーネント  変数を渡す場合は:プロパティ名="$変数"--}}
    <x-tests.card  title="Component_title1" content="Component1の本文" :messages="$messages"/>

    {{-- components/tests/card.blade.php -@props([])から呼び出し --}}
    <x-tests.card  title="Component1_title2"/>

    {{-- 属性:CSSの設定 --}}
    <x-tests.card  title="CSSの変更" class="bg-red-400" />
</x-tests.app>
