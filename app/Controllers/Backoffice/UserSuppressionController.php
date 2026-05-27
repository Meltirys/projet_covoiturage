<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;

class UserSuppressionController extends BaseController{

    public function index(){
        return view('backoffice/UserSuppression.php');
    }
}