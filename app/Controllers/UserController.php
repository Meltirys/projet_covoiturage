<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\EmailTemplates;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Validators\ChangePasswordValidator;
use App\Models\CityModel;
use App\Models\JourneyDriveModel;
use App\Models\JourneyRequestModel;
use App\Models\RequestMemberModel;
use App\Services\LocationService;
use App\Validators\RegistrationValidator;
use App\Services\MailService;
use App\Validators\AvatarValidator;
use App\Validators\UpdateUserInfos;
use App\Validators\BanUserValidator;

class UserController extends BaseController
{

    /**
     * Attempts registration of the user from post content
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
            return redirect()->back()
            ->with('signup_error', true)
            ->withInput()
            ->with('errors', $validator->getErrors());
    
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

        try { //Creating MailService object to be able to send the mail
            $mailService = new MailService();
            helper('mail_helper');
            //Sending the welcome mail
            $mailService->send(
                $user['email'],
                'Bienvenue chez les PennRiders',
                EmailTemplates::accountCreated($user['first_name'])
            );
        } catch (\Exception $e) {
            log_message('error', 'Email de bienvenue non envoyé pour : ' . $user['email'] . '. ' . $e->getMessage());
        }


        return redirect()->to('/')
            ->with('success', 'Compte créé avec succès !');
    }

    /**
     * Delete the user from the data base. Access route is /user/delete. When no id, deletes the connected user.
     * @param int $idUser Optionnal : The id of the user to delete. If no id is provided, delete the connected user.
     * 
     */
    public function delete(int $idUser = -1)
    {
        //If no user is provided, then we retrieve the id of the connected user
        if ($idUser === -1) {
            $idUser = session()->user_id;
        }

        //Setting up the models
        $journeyModel = new JourneyDriveModel();
        $bookingModel = new BookingModel();
        $carModel = new CarModel();
        $userModel = new UserModel();
        $journeyRequestModel = new JourneyRequestModel();
        $requestMemberModel = new RequestMemberModel();


        // ---- We retrieve the datas of the passengers which were supposed to be in a journey made by the deleted user
        $passengerInfos = $journeyModel->getPassengerInfosByUserId($idUser);
        $passengerInfos = $this->regroupInfosByUser($passengerInfos);

        // ---- We retrieve the datas of the drivers where the deleted user had reservations
        $driversInfos = $bookingModel->getDetailedBookingsByUserId($idUser);
        $driversInfos = $this->regroupInfosByUser($driversInfos);


        // ---- We delete the journey drive where the user is the driver
        $journeyModel->where('driver', $idUser)
            ->where('departure >=', date('Y-m-d'))
            ->set('deletion_date', date('Y-m-d'))
            ->update();

        // ---- We delete the bookings of the deleted user
        $bookingModel->where('id_user', $idUser)
            ->whereIn('id_journey_drive', function ($builder) {
                // This sub-query return the ids of all the futur journey
                return $builder->select('id_journey_drive')
                    ->from('JourneyDrive')
                    ->where('departure >=', date('Y-m-d'));
            })
            ->set('deletion_date', date('Y-m-d'))
            ->set('is_validated', false)
            ->update();


        // ---- We delete the request of the user
        $journeyRequestModel->builder()
            ->where('id_creator', $idUser)
            ->where('deletion_date IS NULL')
            ->set('deletion_date', date('Y-m-d'))
            ->update();

        //Deleting the request members linked to the deleted requests
        $requestIds = $journeyRequestModel->where('id_creator', $idUser)
            ->where('deletion_date', date('Y-m-d'))
            ->findColumn('id_journey_request');

        if (!empty($requestIds)) {
            $requestMemberModel->builder()
                ->whereIn('id_journey_request', $requestIds)
                ->where('deletion_date IS NULL')
                ->set('deletion_date', date('Y-m-d'))
                ->set('is_validated', false)
                ->update();
        }

        // ---- We delete the participation of the user in requests
        $requestMemberModel->builder()
            ->where('id_user', $idUser)
            ->where('deletion_date IS NULL')
            ->set('deletion_date', date('Y-m-d'))
            ->set('is_validated', false)
            ->update();

        // ---- We delete the car of the user
        $carModel->where('id_user', $idUser)->delete();

        $userName = $userModel->getUserName($idUser);
        $userMail = $userModel->find($idUser)['email'];

        if (! $userModel->delete($idUser)) {
            $errors = $userModel->errors();

            //Checking if the user that delete the account is the connected user, if so we disconnect him
            if ($idUser == session()->user_id) {
                return redirect()->to('/myprofil')
                    ->with('errors', $errors)
                    ->withInput()
                    ->with('user_error', 'Une erreur est survenue lors de la suppression du compte'); //Return to the user profil with the error
            } else { //This means the account has been deleted by the admin
                return redirect()->to('/backoffice')
                    ->with('suppression_error', "Une erreur est survenue lors de la suppression du compte")
                    ->with('show_suppression', true);
            }
        }

        try {
            //Creating MailService object to be able to send the mail
            $mailService = new MailService();
            helper('mail_helper');

            //Sending the welcome mail
            $mailService->send(
                $userMail,
                'Votre compte chez les PennRiders a été supprimé',
                EmailTemplates::accountDeleted($userName)
            );
        } catch (\Exception $e) {
            log_message('error', 'Email de bienvenue non envoyé pour : ' . $userMail . '. ' . $e->getMessage());
        }

        //Checking if the user that delete the account is the connected user, if so we disconnect him
        if ($idUser == session()->user_id) {
            //Logging the user out
            session_destroy();
            return redirect()->to('/');
        } else { //This means the account has been deleted by the admin
            return redirect()->to('/backoffice')
                ->with('suppression_success', "L'utilisateur " . $userName . " à bien été supprimé")
                ->with('show_suppression', true);
        }
    }

    /**
     * Updates the informations of the connected user with the post content. Doesn't intend to change avator nor password, they have dedicated functions
     */
    public function update()
    {
        helper('form');

        $post = $this->request->getPost();

        $post['id_user'] = session()->user_id; //Have to add this line so the validator ignores the line of the current user when checking for the mail.

        //Calling the specific validator
        $validator = new UpdateUserInfos();

        //If an error is detected, return to the form with the errors described
        if (!$validator->validate($post)) {
            return redirect()->to('/profil/modify')
                ->with('user_update_error', $validator->getErrors());
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
         * Tries to update an user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $userModel->update(session()->user_id, $user)) {
            $errors = $userModel->errors();

            return redirect()->to('/profil/modify')
                ->with('errors', $errors)
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la sauvegarde de vos informations');
        }

        //Updating informations for the session
        session()->set([
            'user_first_name' => $user['first_name'],
            'user_last_name' => $user['last_name'],

        ]);
        //Updating the avatar if a new one has been submitted
        if (array_key_exists('avatar_filename', $user)) {
            session()->set([
                'avatar_filename' => $user['avatar_filename'],
            ]);
        }

        return redirect()->to('/profil/modify')
            ->with('success', 'Vos informations personnelles ont bien été modifiées');
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
            return redirect()->to('profil/changePassword')
                ->with('password_change_error', $validator->getErrors()); // Returns to the url including the errors
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

    /**
     * Update the avatar of the connected user
     */
    public function updateAvatar()
    {

        $validation = service('validation');

        $validation->setRules([
            'avatar' => [
                'rules' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]|max_dims[avatar,1920,1080]',
                'errors' => [
                    'is_image' => 'Le fichier doit être une image',
                    'mime_in'  => 'Format accepté : jpg, jpeg, png, webp',
                    'max_size' => 'L\'image ne doit pas dépasser 2Mo',
                    'max_dims' => 'L\'image ne doit pas dépasser 1920x1080 pixels',
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/profil/modify')
                ->with('avatar_update_error', $validation->getErrors())
                ->withInput();
        }

        $file = $this->request->getFile('avatar');
        // --- Preparing the avatar ---
        if ($file->isValid() && !$file->hasMoved()) {
            // Generating a random name
            $newName = $file->getRandomName();

            //Saving the old avatar filename
            $oldAvatar = session('avatar_filename');

            // Moving the file in the desired directory
            $file->move(ROOTPATH . 'public/img/avatars', $newName);

            // Only saving the name of the file in the database
            $avatarFilename = $newName;

            $userModel = model('UserModel');

            /* 
         * Tries to update an user. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
            if (! $userModel->update(session()->user_id, [
                'avatar_filename' => $avatarFilename
            ])) {
                $errors = $userModel->errors();

                return redirect()->to('/profil/modify')
                    ->with('errors', $errors)
                    ->withInput()
                    ->with('error', 'Une erreur est survenue lors de la sauvegarde de vos informations');
            }

            //Removing the old avatar
            if ($oldAvatar && file_exists(ROOTPATH . 'public/img/avatars/' . $oldAvatar)) {
                unlink(ROOTPATH . 'public/img/avatars/' . $oldAvatar);
            }

            //Updating the session with the new avatar
            session()->set([
                'avatar_filename' => $avatarFilename
            ]);

            return redirect()->to('/profil/modify')
                ->with('success', 'Votre nouvel avatar est maintenant visible');
        } else {
            return redirect()->to('/profil/modify')
                ->with('error', 'Une erreur est survenue lors de la sauvegarde de vos informations');
        }
    }

    /**
     * Delete the avatar of the connected user
     */
    public function deleteAvatar()
    {
        $oldAvatar = session('avatar_filename');

        if ($oldAvatar && file_exists(ROOTPATH . 'public/img/avatars/' . $oldAvatar)) {
            unlink(ROOTPATH . 'public/img/avatars/' . $oldAvatar);
        }

        $userModel = model('UserModel');
        $userModel->update(session()->user_id, ['avatar_filename' => null]);

        session()->set(['avatar_filename' => null]);

        return redirect()->to('/profil/modify')
            ->with('success', 'Avatar supprimé avec succès');
    }

    /**
     * Ban the given user. Access route is /user/ban/{idUser} (only for admins)
     * @param int $idUser The id of the user we want to ban
     */
    public function ban(int $idUser)
    {
        $userModel = model('UserModel');

        $datas['id_user'] = $idUser; //Preparing the datas for the validator
        $validator = new BanUserValidator();
        $userInfos = $userModel->find($idUser);

        if (!$validator->validate($datas)) {
            return redirect()->to('/backoffice')
                ->with('ban_error', $validator->getError('id_user'))
                ->with('show_ban', true);
        }

        //Checking if an error happens when banning the user
        if (!$userModel->update($idUser, [
            'is_validated' => 0
        ])) {
            return redirect()->to('/backoffice')
                ->with('ban_error', 'Une erreur est survenue lors du banissement de l\'utilisateur, veuillez réessayer')
                ->with('show_ban', true);
        }

        //Sending the mail
        try {
            //Creating MailService object to be able to send the mail
            $mailService = new MailService();
            helper('mail_helper');

            //Sending the welcome mail
            $mailService->send(
                $userInfos['email'],
                'Votre compte a été banni du service offert par PennRiders',
                EmailTemplates::accountBanned($userInfos['first_name'])
            );
        } catch (\Exception $e) {
            log_message('error', 'Email de bienvenue non envoyé pour : ' . $userInfos['email'] . '. ' . $e->getMessage());
        }

        //If no errors
        return redirect()->to('/backoffice')
            ->with('ban_success', "L'utilisateur " . $userModel->getUserName($idUser) . " a été bannis avec succès")
            ->with('show_ban', true);
    }

    /**
     * Regroups the datas retrivied via JourneyModel->getPassengerInfosByUserId or BookingModel->getDetailedBookingsByUserId in order to sort it by user. It returns an array with the name and the journey of the users
     * @param array $infos Datas from JourneyModel->getPassengerInfosByUserId or BookingModel->getDetailedBookingsByUserId
     * 
     * @return array An associative array [
     *      [idUser] => [
     *                  'name' => The name of the user,
     *                  'journeyInfos' => [
     *                              [   ["departure_postcode"]=> string(5) "56100",
     *                                  ["departure_city"]=> string(7) "Lorient",
     *                                  ["arrival_postcode"]=> string(5) "56000",
     *                                  ["arrival_city"]=> string(6) "Vannes"
     *                              ],
     *                              ...
     *                          ]
     *              ],
     *         ....
     * ]
     */
    private function regroupInfosByUser(array $infos): array
    {
        $result = [];

        foreach ($infos as $info) {
            if (!array_key_exists($info['id_user'], $result)) {
                $result[$info['id_user']] = ['name' => $info['name']];
                $result[$info['id_user']]['journeyInfo'] = [];
            }

            //Filtering the unused values and adding the rest to the journey infos
            $unwantedKeys = ['id_user' => true, 'name' => true];
            $journeyInfos = array_diff_key($info, $unwantedKeys);
            array_push($result[$info['id_user']]['journeyInfo'], $journeyInfos);
        }

        return $result;
    }
}
