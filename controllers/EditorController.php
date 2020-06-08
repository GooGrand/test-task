<?php

class EditorController extends Controller
{
    public function process($params)
    {
        $this->authUser(true);
        // HTML head
        $this->head['title'] = 'User editor';
        // Creates a model instance
        $userGetter = new UserGetter();
        // Prepares an empty article
        $user = array(
            'user_id' => '',
            'name' => '',
            'surname' => '',
            'email' => '',
            'birthday' => '',
        );
        if ($_POST)
        {
            $keys = array('name', 'surname', 'email', 'birthday');
            $user = array_intersect_key($_POST, array_flip($keys));
            $userGetter->saveUser($_POST['user_id'], $user);
            $this->addMessage('The user was successfully saved.');
            $this->redirect('article/' . $user['user_id']);
        }
        // Was the article URL entered with the intent to edit said article?
        else if (!empty($params[0]))
        {
            $loadedUser = $userGetter->getUser($params[0]);
            if ($loadedUser)
                $user = $loadedUser;
            else
                $this->addMessage('The user was not found.');
        }

        $this->data['user'] = $user;
        $this->view = 'editor';
    }
}