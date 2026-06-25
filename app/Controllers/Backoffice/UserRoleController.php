<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Validators\ChangeRoleValidator;
use PhpParser\Node\Expr\AssignOp\Mod;


class UserRoleController extends BaseController
{
    public function index()
    {
        return view('backoffice/UserRole.php');
    }

    /**
     * @return \CodeIgniter\HTTP\ResponseInterface A json format of the available roles in the app
     */
    public function getAllPermissions(): \CodeIgniter\HTTP\ResponseInterface
    {
        $userPermissionModel = model('UserPermissionModel');
        $results   = $userPermissionModel->getAvailablesRoles();

        return $this->response->setJSON($results);
    }

    /**
     * Modifies the role of a given user. Access route is /user/updateRole/{idUser}
     * @param int $idUser The id of the user we want to modify
     */
    public function updateUserRole(int $idUser)
    {
        $userModel = model('UserModel');

        $post = $this->request->getPost();
        $post['id_user'] = $idUser;

        $validator = new ChangeRoleValidator();

        if (!$validator->validate($post)) {
            return redirect()->to('/backoffice')
                ->with('role_error', $validator->getError('id_user'))
                ->with('active_tab', 'tab-roles');
        }


        if (!$userModel->updateUserRole($idUser, $post['new_role'])) {
            return redirect()->to('/backoffice')
                ->with('role_error', "Une erreur est survenue lors du changement de rôle de l'utilisateur, veuillez réessayer.")
                ->with('active_tab', 'tab-roles');
        }

        return redirect()->to('/backoffice')
            ->with('role_success', "Le role de " . $userModel->getUserName($idUser) . " a bien été modifié.")
            ->with('active_tab', 'tab-roles');
    }
}
