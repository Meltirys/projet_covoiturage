<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index(){
    }

    /**
     * Returns the login view (consider renaming this to view() and loginAttempt() to just login() later)
     */
    public function login()
    {
        helper('form');

        return view('auth/login');
    }

    /**
     * Attempts a login with provided email and password
     */
    public function loginAttempt()
    {
        $userModel = new UserModel();

        $data = [
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
        ];

        $user = $userModel->where('email', $data['email'])->first();

        // If not found or if passwords don't match, fail login
        if (!$user || !password_verify($data['password'], $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', 'Identifiants invalides');
        }

        // If all checks succeed, sets the user information in the session
        session()->set([
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'logged_in' => true,
        ]);
        return redirect()->to('/'); // return to index
    }

    /**
     * Destroys the session and redirects to front page
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * Returns the register view
     */
    public function register()
    {
        helper('form');

        return view('auth/register_form');
    }

    /**
     * Attempts registration from post content
     */
    public function registerAttempt()
    {
        
        helper('form');

        return redirect()->to('/');
        $userModel = new UserModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
            'mobile'     => $this->request->getPost('mobile'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender'     => $this->request->getPost('gender'),
        ];

        /* 
         * Tries to save a new user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $userModel->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $userModel->errors());
        }

        return redirect()->to('/login')
            ->with('success', 'Compte créé avec succès');
    }
}
