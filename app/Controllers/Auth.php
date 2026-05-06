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
     * Checks the inputted information and attempts to register a new user 
     */
    public function registerAttempt()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => "Adresse email requise",
                    'valid_email' => "Veuillez entrer une adresse email valide"
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]).+$/]',
                'errors' => [
                    'required'   => 'Un mot de passe est requis',
                    'min_length' => 'Votre mot de passe doit faire 8 caractères minimum',
                    'max_length' => 'Votre mot de passe ne doit pas dépasser 255 caractères',
                    'regex_match' => 'Votre mot de passe doit contenir au moins une majuscule, minuscule, un nombre et un caractère spécial'
                ]
            ]
        ];

        // If there are errors, returns to view with them in the following format :
        // [ 'field1' => 'error message', 'field2' => 'error message', ]
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Checks whether the email is used within the database
        $model = new UserModel;
        $isUsed = $model->insert(['first_name' => ]);
        // If it's already in use, returns to the view with an error
        if ($isUsed) {
            return redirect()->back()
                ->with('error', 'Cet adresse email est déjà utilisée');
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
}
