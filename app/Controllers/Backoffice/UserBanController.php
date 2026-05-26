<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;

class UserBanController extends BaseController{
    public function index(){
        return view('backoffice/UserBan');
    }
}