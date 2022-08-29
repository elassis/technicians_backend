<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {

        if (!Auth::attempt([
          'email' => $request->email,
          'password' => $request->password,
        ])) {
          throw ValidationException::withMessages([
          'email' => [
             __('auth.failed')
          ],
          'password' => [
            __('auth.failed')
          ]
          ]);
           //return $request->password;
        }

        return redirect()->intended('api/index');

    }
}
