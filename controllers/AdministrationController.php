<?php

class AdministrationController extends Controller
{
    public function process($params)
    {
        // Only registered users can access the administration page
        $this->authUser();
        // HTML head
        $this->head['title'] = 'Login';
        // Retrieving user data (if he/she is logged in)
        $userManager = new UserManager();
        if (!empty($params[0]) && $params[0] == 'logoff')
        {
            $userManager->logoff();
            $this->redirect('login');
        }
        $user = $userManager->getUser();
        $this->data['name'] = $user['name'];
        $this->data['admin'] = $user['admin'];
        // Setting the template
        $this->view = 'administration';
    }
}