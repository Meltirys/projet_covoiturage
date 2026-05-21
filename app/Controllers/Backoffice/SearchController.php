<?php
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;

class SearchController extends BaseController
{
    public function searchUser(string $search): \CodeIgniter\HTTP\ResponseInterface
    {
        $userModel = model('UserModel');
        $results   = $userModel->searchForUserByName($search);

        return $this->response->setJSON($results);
    }
}