<?php

namespace App\Controllers;

class BackOfficeController extends BaseController{
    public function validateUser(){
        $dbUser = model('UserModel');
        $userToValidate = $dbUser->getNonValidatedUsers();
        return view('backoffice/userValidation', $userToValidate);
    }
}