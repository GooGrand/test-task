<?php

class LoginController extends Controller
{
    public function process($params)
    {
        $userManager = new UserManager();
        if ($userManager->getUser())
            $this->redirect('administration');
        // HTML head
        $this->head['title'] = 'Login';
        if ($_POST)
        {
            try
            {
                $userManager->login($_POST['name'], $_POST['password']);
                $this->addMessage('You were successfully logged in.');
                $this->redirect('administration');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        // Sets the template
        $this->view = 'login';
    }
}