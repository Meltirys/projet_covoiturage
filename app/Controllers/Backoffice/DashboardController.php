<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Models\ReportModel;

class DashboardController extends BaseController
{
    public function index()
    {
        helper('form');
        helper('french');

        //Loading the non validated user.
        $dbUser = model('UserModel');
        $data['users'] = $dbUser->getNonValidatedUsers();

        $reportModel = model('ReportModel');
        $data['reports'] = $reportModel->getReportInformations(); //Retrieving the non resolved reports

        //Transforming the dates
        foreach ($data['reports'] as &$report) {
            $report['date'] = format_date_fr($report['date']);
        }
        unset($report); //Cleaning the memory

        $data['reportsHistory'] = $reportModel->getReportInformations(true); //Retrieving the resolved reports

        //Transforming the dates
        foreach ($data['reportsHistory'] as &$report) {
            $report['date'] = format_date_fr($report['date']);
        }
        unset($report); //Cleaning the memory

        return view('backoffice/Dashboard', $data);
    }
}
