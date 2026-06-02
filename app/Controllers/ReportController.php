<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Validators\ReportValidator;

class ReportController extends BaseController
{
    public function showReportView()
    {
        helper('form');
        return view('templates/ReportForm.php');
    }

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
}
