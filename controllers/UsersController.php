<?php

class UsersController extends Controller
{
    public function index()
    {
//        $allProducts = count($)
    }
    public function process($params)
    {
        $userGetter = new UserGetter();
        $userManager = new UserManager();
        $pagination = new Pagination();
        $user = $userManager->getUser();
        $this->data['admin'] = $user && $user['admin'];

        if (!empty($params[1]) && $params[1] == 'remove')
        {
            $this->authUser(true);
            $userGetter->removeUser($params[0]);
            $this->addMessage('The user was successfully removed');
            $this->redirect('administration');
        }
        else if (!empty($params[0]))
        {
            $article = $userGetter->getUser($params[0]);
            if (!$article)
                $this->redirect('error');

            // HTML head
            $this->head = array(
                'title' => $user['name'],
                'description' => $user['email'],
            );

            // Sets the template variables
            $this->data['name'] = $user['name'];
            $this->data['email'] = $user['email'];

            // Sets the template
            $this->view = 'users';
        }
        else
            // No URL was entered, so we list all of the articles
        {
//            $users = $userGetter->getUsers();
            $this->data['users'] = $pagination->getPage();
            $this->data['page'] = $pagination->page;
            $this->data['num_pages'] = $pagination->getRows();
            $this->data['cur_page'] = $pagination->getCurPage();
            $this->view = 'users';
        }
    }
}