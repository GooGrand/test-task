<?php

class ArticleController extends Controller
{
    public function process($params)
    {
        // Creates a model instance which allows us to access articles
        $articleManager = new ArticleManager();
        // Creates a model instance which allows us to access articles
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $this->data['admin'] = $user && $user['admin'];

        // Removes an article based on its URL
        if (!empty($params[1]) && $params[1] == 'remove')
        {
            $this->authUser(true);
            $articleManager->removeArticle($params[0]);
            $this->addMessage('The article was successfuly removed');
            $this->redirect('article');
        }
        else if (!empty($params[0]))
        {
            // Retrieves an article based on a URL
            $article = $articleManager->getArticle($params[0]);
            // If no article was found we redirect to the ErrorController
            if (!$article)
                $this->redirect('error');

            // HTML head
            $this->head = array(
                'title' => $article['title'],
                'description' => $article['description'],
            );

            // Sets the template variables
            $this->data['title'] = $article['title'];
            $this->data['content'] = $article['content'];

            // Sets the template
            $this->view = 'article';
        }
        else
            // No URL was entered, so we list all of the articles
        {
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }
    }
}