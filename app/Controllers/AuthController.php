<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Validators\RegistrationValidator;
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
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
        ];

        // Gets the row corresponding to the user's email
        $user = $userModel->where('email', $post['email'])->first();

        // If nothing found or if passwords don't match, login fail
        if (!$user || !password_verify($post['password'], $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', 'Identifiants invalides');
        }

        // If all checks succeed, sets the user information in the session
        session()->set([
            'user_id' => $user['id_user'],
            'user_email' => $user['email'],
            'user_role' => $user['id_user_permission'],
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
    public function saveUser()
    {

        helper('form');
        /* To uncomment whent the address/city are made
        $user = [
            'first_name'   => $this->request->getPost('first_name'),
            'last_name'    => $this->request->getPost('last_name'),
            'email'        => $this->request->getPost('email'),
            'password'     => $this->request->getPost('password'),
            'password_conf' => $this->request->getPost('password_conf'),
            'mobile'       => $this->request->getPost('phone'),
            'birth_date'   => $this->request->getPost('birth_date'),
            'gender'       => $this->request->getPost('gender'),
        ];*/

        //Calling the specific validator
        $user = $this->request->getPost();
        $validator = new RegistrationValidator();

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($user)) {
            return view('HomeView', [
                'errors' => $validator->getErrors()
            ]);
        }

        $userModel = model(UserModel::class);

        /* 
         * Tries to save a new user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $userModel->save($user)) {
            $errors = $userModel->errors();

            return redirect()->to('/')
                ->with('errors', $errors)
                ->withInput()
                ->with('status', 'Votre compte n\'a pas pu être crée');
        }

        return redirect()->to('/')
            ->with('status', 'Compte créé avec succès');
    }
}
