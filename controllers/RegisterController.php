<?php

class RegisterController extends Controller
{
    public function process($params)
    {
        // HTML head
        $this->head['title'] = 'Register';

        if ($_POST)
        {
            try {
                $userManager = new UserManager();
                $userManager->register($_POST['name'], $_POST['password'], $_POST['password_repeat'], $_POST['abc']);
                $userManager->login($_POST['name'], $_POST['password']);
                $this->addMessage('You were successfully registered.');
                $this->redirect('administration');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }
        $this->view = 'register';
    }
}