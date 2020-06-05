<?php

class ContactController extends Controller
{
    public function process($params)
    {
        $this->head = array(
            'title' => 'Contact form',
            'description' => 'Contact us using our email form.'
        );

        if ($_POST)
        {
            try
            {
                $emailSender = new EmailSender();
                $emailSender->sendWithAntispam($_POST['abc'], "admin@address.com", "Email from your website", $_POST['message'], $_POST['email']);
                $this->addMessage('The email was successfully sent.');
                $this->redirect('contact');
            }
            catch (UserException $ex)
            {
                $this->addMessage($ex->getMessage());
            }
        }

        $this->view = 'contact';
    }
}