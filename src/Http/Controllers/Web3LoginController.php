<?php

namespace M1guelpf\Web3Login\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use M1guelpf\Web3Login\Web3Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use M1guelpf\Web3Login\Facades\Signature;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class Web3LoginController
{
    public function signature(Request $request)
    {
        $request->session()->put('nonce', $nonce = Str::random());

        return Signature::generate($nonce);
    }

    public function link(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'regex:/0x[a-fA-F0-9]{40}/m'],
            'signature' => ['required', 'string', 'regex:/^0x([A-Fa-f0-9]{130})$/'],
        ]);

        if (! Signature::verify($request->session()->pull('nonce'), $request->input('signature'), $request->input('address'))) {
            throw ValidationException::withMessages(['signature' => 'Signature verification failed.']);
        }

        $request->user()->update([
            'wallet' => strtolower($request->input('address')),
        ]);

        return new Response('', 204);
    }

    public function login(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'regex:/0x[a-fA-F0-9]{40}/m'],
            'signature' => ['required', 'string', 'regex:/^0x([A-Fa-f0-9]{130})$/'],
        ]);

        if (! Signature::verify($request->session()->pull('nonce'), $request->input('signature'), $request->input('address'))) {
            throw ValidationException::withMessages(['signature' => 'Signature verification failed.']);
        }

        if (Web3Login::$retrieveUserCallback) {
            $user = call_user_func(Web3Login::$retrieveUserCallback, strtolower($request->input('address')));
        } else {
            $user = $this->getUserModel()->where('wallet', strtolower($request->input('address')))->first();
        }

        if (! $user) {
            throw ValidationException::withMessages(['address' => 'Address not registered.']);
        }

        Auth::login($user);

        return new Response('', 204);
    }

    protected function getUserModel() : Model
    {
        return app(config('auth.providers.users.model'));
    }
}
