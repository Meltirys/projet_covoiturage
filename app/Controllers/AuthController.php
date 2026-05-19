<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Validators\RegistrationValidator;
use App\Services\MailService;
use Exception;

use function PHPUnit\Framework\throwException;

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

        // If all checks succeed, sets the user information in the session
        session()->set([
            'user_id' => $user['id_user'],
            'user_email' => $user['email'],
            'user_role' => $user['id_user_permission'],
            'user_first_name' => $user['first_name'],
            'user_last_name' => $user['last_name'],
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

}
