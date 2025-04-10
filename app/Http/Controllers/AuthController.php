<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function logout(){
        echo 'logout';
    }

    public function loginSubmit(Request $request){
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16|alpha_num|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,16}$/',
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

        echo ('OK');
    }
}
