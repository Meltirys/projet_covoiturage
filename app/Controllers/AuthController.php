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
        $userModel = new UserModel();

        $data = [
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
        ];

        // Gets the row corresponding to the user's email
        $user = $userModel->where('email', $data['email'])->first();

        // If nothing found or if passwords don't match, login fail
        if (!$user || !password_verify($data['password'], $user['password'])) {
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

        $post = $this->request->getPost();

        //Calling the specific validator
        $validator = new RegistrationValidator();
        

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($post)) {

            return view('HomeView', [
                'errors' => $validator->getErrors()
            ]);
        }


        $userModel = new UserModel();

        //Loading the datas in the database
        $data = [
            'first_name' => $post['first_name'],
            'last_name'  => $post['last_name'],
            'email'      => $post['email'],
            'password'   => password_hash($post['password'], PASSWORD_DEFAULT),
            'mobile'     => $post['phone'],
            'birth_date' => $post['birth_date'],
            'gender'     => $post['gender'],
            'id_user_permission' => 1,
        ];

        /* 
         * Tries to save a new user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $userModel->save($data)) {
            return redirect()->to('/')
                ->with('status', 'Votre compte n\'a pas pu être crée');
        }

        return redirect()->to('/')
            ->with('status', 'Compte créé avec succès');
    }
}
