<?php

class AdminAuthController extends Controller
{
    protected string $layout = 'admin';

    /**
     * Exibir formulário de login
     */
    public function showLogin(): void
    {
        $this->view('admin/login', [], 'blank');
    }

    /**
     * Processar login
     */
    public function login(): void
    {
        $this->validateCsrf();

        $email = $this->input('email');
        $password = $this->input('password');

        if (empty($email) || empty($password)) {
            Session::flash('error', 'Preencha todos os campos.');
            redirect('/admin/login');
        }

        if (Auth::attempt($email, $password)) {
            Session::flash('success', 'Bem-vindo de volta!');
            redirect('/admin');
        }

        Session::flash('error', 'Email ou senha incorretos.');
        redirect('/admin/login');
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        Auth::logout();
        Session::flash('success', 'Sessão encerrada com sucesso.');
        redirect('/admin/login');
    }
}
