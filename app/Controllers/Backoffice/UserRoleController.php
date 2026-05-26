<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use PhpParser\Node\Expr\AssignOp\Mod;

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

    public function updateUserRole(int $idUser)
    {
        $userModel = model('UserModel');

        $post = $this->request->getPost();

        if (!$userModel->updateUserRole($idUser, $post['newRole'])) {

            return redirect()->back()
                ->with('error', "Une erreur est survenue lors du changemenr de rôle de l'utilisateur, veuillez réessayer.");
        }

        return redirect()->back()
            ->with('success',"Le role de " . $userModel->getUserName($idUser) . " a bien été modifié.");;
    }
}
