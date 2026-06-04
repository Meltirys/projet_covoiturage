<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

use Exception;

class AuthController extends BaseController
{

    public function index() {}

    /**
     * Returns the login view
     */
    public function login()
    {
        helper('form');

        return view('auth/login');
    }

    /**
     * Attempts a login with provided email and password
     */
    public function authenticate()
    {
        $userModel = model(UserModel::class);

        $post = [
            'email'      => $this->request->getPost('email-auth'),
            'password'   => $this->request->getPost('password-auth'),
        ];



        // Gets the row corresponding to the user's email
        $user = $userModel->where('email', $post['email'])->first();
        // If nothing found or if passwords don't match, login fail
        if (!$user || !password_verify($post['password'], $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('auth_error', 'Identifiants invalides');
        }

        //Now that we know it's a know user, we have to check if he has access to the website
        $validationStatus = $userModel->getValidationStatusForUser($user['id_user']);

        if ($validationStatus) {
            // If all checks succeed, sets the user information in the session
            session()->set([
                'user_id' => $user['id_user'],
                'user_email' => $user['email'],
                'user_role' => $user['id_user_permission'],
                'user_first_name' => $user['first_name'],
                'user_last_name' => $user['last_name'],
                'avatar_filename' => $user['avatar_filename'],
                'logged_in' => true,
            ]);

            return redirect()->to('/'); // return to index
        } else if (is_null($validationStatus)) {
            return redirect()->back()
                ->withInput()
                ->with('auth_error', "Votre profil n'a pas encore été validé, un administrateur s'en occupe au plus vite.");
        } else {
            return redirect()->back()
                ->withInput()
                ->with('auth_error', "Vous n'êtes pas autorisé à accéder à ce service.");
        }
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
    
}
