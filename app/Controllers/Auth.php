<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Auth extends BaseController
{

    /**
     * Returns the login view
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Attempts a login with provided email and password
     */
    public function loginAttempt()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => "Adresse email requise",
                    'valid_email' => "L'adresse email entrée n'est pas valide",
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Mot de passe requis"
                ]
            ]
        ];

        // If there are errors, returns to view with them in the following format :
        // [ 'field1' => 'error message', 'field2' => 'error message', ]
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Checks if the email and password match a user in database
        $model = new UserModel;
        $user = $model->tryLogin(
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );
        // If it doesn't, returns to the view with a message in $error
        if (! $user) {
            return redirect()->back()
                ->with('error', 'Identifiants invalides');
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
        return view('auth/register');
    }

    /**
     * Acquires register from inputs from post and attempts registration
     */
    public function registerAttempt()
    {
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
