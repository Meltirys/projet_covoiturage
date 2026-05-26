<?php
namespace App\Controllers\Backoffice;
use App\Controllers\BaseController;

class SearchController extends BaseController
{
    /**
     * Function that search a given user in the database. This is only available for admins and his access route is /searchUser/{query}
     * @param string $search The user to research
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function searchUser(string $search): \CodeIgniter\HTTP\ResponseInterface
    {
        $userModel = model('UserModel');
        $results   = $userModel->searchForUserByName($search, session()->user_role);

        return $this->response->setJSON($results);
    }

        /**
     * Function that search a given user in the database, and also send his permissions. This is only available for super-admins and his access route is /searchUserWP/{query}
     * @param string $search The user to research
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function searchUserWithPerm(string $search): \CodeIgniter\HTTP\ResponseInterface
    {
        $userModel = model('UserModel');
        $results   = $userModel->searchForUserByName($search, session()->user_role, true);

        return $this->response->setJSON($results);
    }
}