<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        helper('form');

        //Loading the non validated user.
        $dbUser = model('UserModel');
        $data['users'] = $dbUser->getNonValidatedUsers();

        $reportModel = model('ReportModel');
        $data['reports'] = $reportModel->getNonResolvedReport();

        return view('backoffice/Dashboard', $data);
    }
}
