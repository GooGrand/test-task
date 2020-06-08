<?php

// Manages articles in the system
class UserGetter
{

    // Returns an article from the database based on a URL
    public function getUser($user_id)
    {
        return Db::queryOne('
                        SELECT `user_id`, `name`, `surname`, `email`, `birthday`
                        FROM `users`
                        WHERE `user_id` = ?
                ', array($user_id));
    }

    // Returns a list of all of the articles in the database
    public function getUsers()
    {
        return Db::queryAll('
                        SELECT `user_id`, `name`, `surname`, `email`, `birthday`
                        FROM `users`
                        ORDER BY `user_id` DESC
                ');
    }

    public function saveUser($id, $user)
    {
        if (!$id)
            Db::insert('users', $user);
        else
            Db::update('users', $user, 'WHERE user_id = ?', array($id));
    }

    public function removeUser($user_id)
    {
        Db::query('
                DELETE FROM users
                WHERE user_id = ?
        ', array($user_id));
    }

}