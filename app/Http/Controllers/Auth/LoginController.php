<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    
    public function __invoke(Request $request)
    {
        /*
            replaced attempt() with once() since its better for APIs, reference 
            https://laravel.com/docs/7.x/authentication#other-authentication-methods
        */
        $login_status = auth()->once([
            'email' => request('email'),
            'password' => request('password')
        ]);

        // if correct credinials
        if($login_status){
            $token = User::where('email', request('email'))->firstOrFail()->createToken('user-api', ['user']);
            return response(['token' => $token->plainTextToken]);
        }

        return response('Wronge Credinials.', Response::HTTP_UNAUTHORIZED);
    }
}
