<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Componentを表示するクラス
class ComponentTestController extends Controller
{
    // component-test1表示
    public function showComponent1(){

        // Componentに渡す変数
        $messages ="コンポーネント1のメッセージです!";

        // componetn-test1pageにmessages変数を渡す
        return \view('tests.component-test1',compact('messages'));
    }

    // component-test2表示
    public function showComponent2(){

        // Componentに渡す変数
        $messages ="コンポーネント2のメッセージです!";

        // componetn-test2pageにmessages変数を渡す
        return \view('tests.component-test2',compact('messages'));
    }
}
