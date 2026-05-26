<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;

class UserRoleController extends BaseController
{
    public function index()
    {
        return view('backoffice/UserRole.php');
    }

    public function getAllPermissions(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userPermissionModel = model('UserPermissionModel');
        $results   = $userPermissionModel->getAllAvailablesRoles();

        return $this->response->setJSON($results);
    }
}
