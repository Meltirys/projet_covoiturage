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
        $data['reports'] = $reportModel->getReportInformations(); //Reetrieving the non resolved reports



        foreach ($data['reports'] as &$report) {
            $report['date'] = format_date_fr($report['date']);
        }
        unset($report);

        $data['reportsHistory'] = $reportModel->getReportInformations(true); //Reetrieving the resolved reports

        foreach ($data['reportsHistory'] as &$report) {
            $report['date'] = format_date_fr($report['date']);
        }
        unset($report);

        return view('backoffice/Dashboard', $data);
    }
}
