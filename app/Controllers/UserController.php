<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Validators\ChangePasswordValidator;
use App\Models\CityModel;
use App\Services\LocationService;
use App\Validators\RegistrationValidator;
use App\Services\MailService;
use App\Validators\UpdateUserInfos;
use PhpParser\Node\Expr\AssignOp\Mod;

class UserController extends BaseController
{

    /**
     * Attempts registration from post content
     */
    public function saveUser()
    {

        helper('form');

        $post = $this->request->getPost();
        $post['email'] = $this->request->getPost('email-signup');

        //Calling the specific validator
        $validator = new RegistrationValidator();

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($post)) {
            return view('HomeView', [
                'errors' => $validator->getErrors()
            ]);
        }
        // --- Saving the location --- 
        $location = [
            'address' => $this->request->getPost('address'),
            'postcode' => $this->request->getPost('postcode'),
            'city' => $this->request->getPost('city'),
        ];
        $locationService = new LocationService();

        $idLocation = $locationService->getOrCreate($location['address'], $location['city'], $location['postcode']);

        // --- Saving in the user table ---
        //Retrieving the information for the user table
        $user = [
            'first_name'   => $this->request->getPost('first_name'),
            'last_name'    => $this->request->getPost('last_name'),
            'email'        => $this->request->getPost('email-signup'),
            'password'     => $this->request->getPost('password'),
            'mobile'       => $this->request->getPost('mobile'),
            'birth_date'   => $this->request->getPost('birth_date'),
            'gender'       => $this->request->getPost('gender'),
            'id_location'  => $idLocation
        ];

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
                ->with('signup_error', 'Votre compte n\'a pas pu être créé');
        }

        /* Mail: To uncomment in production
        //Creating MailService object to be able to send the mail
        $mailService = new MailService();

        //We test if the mail is correctly sent or not, if not we insert a line in the logs
        if (!$mailService->sendWelcome($user['email'], $user['first_name'])) {
            log_message('error', 'Email de bienvenue non envoyé pour : ' . $user['email']);
        }*/

        return redirect()->to('/')
            ->with('success', 'Compte créé avec succès !');
    }

    /**
     * Delete the user from the data base. Access route is /user/delete
     * @param int $idUser Optionnal : The id of the user to delete. If no id is provided, delete the connected user.
     * 
     */
    public function delete(int $idUser = -1)
    {
        if ($idUser === -1) {
            $idUser = session()->user_id;
        }

        //We delete the car of the user
        $carModel = new CarModel();
        $carModel->where('id_user', $idUser)->delete();

        $userModel = new UserModel();
        $userName = $userModel->getUserName($idUser);

        if (! $userModel->delete($idUser)) {
            $errors = $userModel->errors();

            //Checking if the user that delete the account is the connected user, if so we disconnect him
            if ($idUser == session()->user_id) {
                return redirect()->to('/myprofil')
                    ->with('errors', $errors)
                    ->withInput()
                    ->with('user_error', 'Une erreur est survenue lors de la suppression du compte'); //Return to the user profil with the error
            } else { //This means the account has been deleted by the admin
                return redirect()->to('/userSuppression')
                    ->with('error', "Une erreur est survenue lors de la suppression du compte");
            }
        }

        //Checking if the user that delete the account is the connected user, if so we disconnect him
        if ($idUser == session()->user_id) {
            //Logging the user out
            $authController = new AuthController();
            $authController->logout();
        } else { //This means the account has been deleted by the admin
            return redirect()->to('/userSuppression')
                ->with('success', "L'utilisateur " . $userName . " à bien été supprimé");
        }
    }

    /**
     * Preloads the informations of the user and displays it. Access route is /user/modify
     */
    public function modify()
    {
        helper('form');

        $data['user'] = $this->loadUserInfos();

        return view('profil/modify', $data);
    }

    public function update()
    {
        helper('form');

        $post = $this->request->getPost();

        $post['id_user'] = session()->user_id; //Have to add this line so the validator ignores the line of the current user when checking for the mail.

        //Calling the specific validator
        $validator = new UpdateUserInfos();

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($post)) {
            var_dump($validator->getErrors());
            $user = $this->loadUserInfos();
            return view('profil/modify',[
                'user' => $user,
                'errors' => $validator->getErrors()
            ]);

        }

        // --- Saving the location --- 
        $location = [
            'address' => $this->request->getPost('address'),
            'postcode' => $this->request->getPost('postcode'),
            'city' => $this->request->getPost('city'),
        ];
        $locationService = new LocationService();

        $idLocation = $locationService->getOrCreate($location['address'], $location['city'], $location['postcode']);

        // --- Saving in the user table ---
        //Retrieving the information for the user table
        $user = [
            'first_name'   => $this->request->getPost('first_name'),
            'last_name'    => $this->request->getPost('last_name'),
            'email'        => $this->request->getPost('email'),
            'mobile'       => $this->request->getPost('mobile'),
            'birth_date'   => $this->request->getPost('birth_date'),
            'gender'       => $this->request->getPost('gender'),
            'id_location'  => $idLocation
        ];

        $userModel = model(UserModel::class);

        /* 
         * Tries to save a new user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $userModel->update(session()->user_id, $user)) {
            $errors = $userModel->errors();

            return redirect()->to('/user/modify')
                ->with('errors', $errors)
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la sauvegarde de vos informations');
        }

        return redirect()->to('/user/modify')
            ->with('success', 'Vos informations personnelles ont bien été modifiées');
    }

    /*
    * Shows the page where the password can be changed. Access route is /user/changePassword
    */
    public function showPasswordChange()
    {
        helper('form');

        return view('profil/changePassword');
    }

    /**
     * Update the password of the connected user. Access route is /user/updatePassword
     */
    public function updatePassword()
    {
        helper('form');

        $password = [
            'old_password' => $this->request->getPost('old_password'),
            'password' => $this->request->getPost('password'),
            'password_conf' => $this->request->getPost('password_conf')
        ];

        $validator = new ChangePasswordValidator();

        if (!$validator->validate($password)) {
            return view('profil/changePassword', [
                'errors' => $validator->getErrors()
            ]);
        }

        $userModel = new UserModel();

        //Checking if an error happens when saving the new password
        if (!$userModel->update(session()->get('user_id'), [
            'password' => password_hash($password['password'], PASSWORD_DEFAULT)
        ])) {
            return redirect()->to('profil/changePassword')
                ->with('password_error', 'Une erreur est survenue lors de la modification, veuillez réessayer');
        }

        //If no errors
        return redirect()->to('profil/changePassword')
            ->with('password_success', 'Mot de passe modifié avec succès.');
    }

    private function loadUserInfos(): array
    {
        $userModel = model('UserModel');
        $cityModel = model('CityModel');
        $locationModel = model('LocationModel');

        $user = $userModel->find(session()->user_id); // Retrieving the user infos

        $address = $locationModel->find($user['id_location']); // Retrieving the address
        $user['address'] = $address['address'];

        $city = $cityModel->find($address['id_city']); //Retrieving the city infos
        $user['city'] = $city['name'];
        $user['postcode'] = $city['postcode'];

        return $user;
    }
}
