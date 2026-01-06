<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        $guard = $request->routeIs('admin.*') ? 'admin' : 'web';

        Auth::guard($guard)->logout();
        $request->session()->regenerateToken();

        return redirect($guard === 'admin' ? '/admin/login' : '/login');
    }
}
