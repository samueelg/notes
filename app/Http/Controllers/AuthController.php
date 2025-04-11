<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function logout(){
        session()->forget('user');
        return redirect()->to('/login');
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16',
        ],
        [
            'text_username.required' => 'É necessario preencher o campo de email',
            'text_username.email' => 'O email deve ser valido',
            'text_password.required' => 'É necessario preencher o campo de senha',
            'text_password.min' => 'A senha deve ter no minimo 6 caracteres',
            'text_password.max' => 'A senha deve ter no maximo 16 caracteres',
            'text_password.alpha_num' => 'A senha deve conter apenas letras e numeros',
            'text_password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número',
        ]
    );
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        if (!$user){
            return redirect()
                   ->back()
                   ->withInput()
                   ->with('loginError', 'Email ou senha incorretos');
        }

        if (!password_verify($password, $user->password)){
            return redirect()
                   ->back()
                   ->withInput()
                   ->with('loginError', 'Email ou senha incorretos');

        }

        //update last_login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        return redirect()->to('/');
    }
}
