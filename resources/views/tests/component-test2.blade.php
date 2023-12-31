<x-tests.app>
    {{-- view/component/tests/app.blade.php用header--}}
    <x-slot name="header">
        コンポーネントテスト2Heaeder
    </x-slot>
    {{-- view/component/tests/app.blade.php用コンポーネント--}}
    コンポーネントテスト2

    {{-- cardへ値を受け渡しをするコンポーネント 変数を渡す場合は:プロパティ名="$変数"---}}
    <x-tests.card  title="Component2_title1" content="Component2の本文" :messages="$messages"/>

    {{-- components/tests/card.blade.php -@props([])から呼び出し--}}
    <x-tests.card  title="Component1_title2" />

    {{-- 属性:CSSの設定 --}}
    <x-tests.card  title="CSSの変更" class="bg-green-400" />

    {{-- test-class-base.blade.phpの呼び出し --}}
    <x-test-class-base classBaseMessage="メッセージ1"/>
    <div class="mb-4"></div>
    <x-test-class-base classBaseMessage="メッセージ2" defaultMessage="初期値より変更しています" />
</x-tests.app>
