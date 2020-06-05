<?php

// Manages articles in the system
class ArticleManager
{

    // Returns an article from the database based on a URL
    public function getArticle($url)
    {
        return Db::queryOne('
                        SELECT `article_id`, `title`, `content`, `url`, `description`
                        FROM `article`
                        WHERE `url` = ?
                ', array($url));
    }

    // Returns a list of all of the articles in the database
    public function getArticles()
    {
        return Db::queryAll('
                        SELECT `article_id`, `title`, `url`, `description`
                        FROM `article`
                        ORDER BY `article_id` DESC
                ');
    }

    public function saveArticle($id, $article)
    {
        if (!$id)
            Db::insert('article', $article);
        else
            Db::update('article', $article, 'WHERE article_id = ?', array($id));
    }

    public function removeArticle($url)
    {
        Db::query('
                DELETE FROM article
                WHERE url = ?
        ', array($url));
    }

}