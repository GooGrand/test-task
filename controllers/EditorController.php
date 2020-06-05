<?php

class EditorController extends Controller
{
    public function process($params)
    {
        $this->authUser(true);
        // HTML head
        $this->head['title'] = 'Article editor';
        // Creates a model instance
        $articleManager = new ArticleManager();
        // Prepares an empty article
        $article = array(
            'article_id' => '',
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => '',
        );
        // Was the form submitted?
        if ($_POST)
        {
            // Retrieves the article from POST
            $keys = array('title', 'content', 'url', 'description');
            $article = array_intersect_key($_POST, array_flip($keys));
            // Stores the article into the database
            $articleManager->saveArticle($_POST['article_id'], $article);
            $this->addMessage('The article was successfully saved.');
            $this->redirect('article/' . $article['url']);
        }
        // Was the article URL entered with the intent to edit said article?
        else if (!empty($params[0]))
        {
            $loadedArticle = $articleManager->getArticle($params[0]);
            if ($loadedArticle)
                $article = $loadedArticle;
            else
                $this->addMessage('The article was not found.');
        }

        $this->data['article'] = $article;
        $this->view = 'editor';
    }
}