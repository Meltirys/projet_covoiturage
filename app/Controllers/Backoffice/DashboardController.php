<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Models\ReportModel;

class DashboardController extends BaseController
{
    public function index()
    {
        helper('form');

        //Loading the non validated user.
        $dbUser = model('UserModel');
        $data['users'] = $dbUser->getNonValidatedUsers();

        $reportModel = model('ReportModel');
        $data['reports'] = $reportModel->getReportInformations(); //Reetrieving the non resolved reports
        $data['reportsHistory'] = $reportModel->getReportInformations(true); //Reetrieving the resolved reports

        return view('backoffice/Dashboard', $data);
    }
}
