<?php

namespace App\Actions\Responses;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('login'); // ログアウト後に login にリダイレクト
    }
}