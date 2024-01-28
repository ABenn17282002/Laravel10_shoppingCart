<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// Auth,Sessionクラス
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SaveUsernameToSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // ログインユーザーの場合、セッションにユーザー名を保存
            Session::put('username', Auth::user()->name);
        } else {
            // 非ログインユーザーの場合、セッションからユーザー名を削除
            Session::forget('username');
        }
        return $next($request);
    }
}
