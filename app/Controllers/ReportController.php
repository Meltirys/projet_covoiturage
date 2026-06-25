<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Validators\ReportValidator;

class ReportController extends BaseController
{

    /**
     * Reports a given user. The reporter is setted to be the connected user.
     * @param int $idUser The user to report
     */
    public function report(int $idUser)
    {
        helper('form');
        //Checking if the user tries to report himself
        if ($idUser == session()->user_id) {
            return redirect()->back()
                ->with('error', "Vous ne pouvez pas vous reporter vous même");
        }

        $datas = [
            'reporter' => session()->user_id,
            'reported' => $idUser,
            'comment' => $this->request->getPost('comment')
        ];

        $validator = new ReportValidator();

        if (!$validator->validate($datas)) {
            return redirect()->to('report')
                ->with('error', 'Un champ n\'était pas valide');
        }

        $reportModel = model('ReportModel');

        if (!$reportModel->save($datas)) {
            return redirect()->to('report')
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement du signalement, veuillez réessayer');
        }

        return redirect()->to('report')
            ->with('success', 'Le signalement à bien été pris en compte, il sera le traité le plus rapidement possible par nos administrateurs');
    }

    /**
     * Mark the report as solved in the database
     * @param int $idReport The id of the report we want to solve
     */
    public function solve(int $idReport)
    {
        $reportModel = model('ReportModel');

        if (!$reportModel->update($idReport, [
            'is_resolved' => true
        ])) {
            redirect()->to('backoffice')
                ->with('report_error', 'Une erreur est survenue lors de la résolution du signalement, veuillez réessayer');
        }

        return redirect()->to('backoffice')
            ->with('report_success', 'Le signamelement a bien été marqué comme résolu');
    }
}
