<?php

class UserManager
{
    public function computeHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function register($name, $surname, $email, $birthday, $password, $passwordRepeat, $year)
    {
        if ($year != date('Y'))
            throw new UserException('Invalid antispam.');
        if ($password != $passwordRepeat)
            throw new UserException('Password mismatch.');
        $user = array(
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'birthday' => $birthday,
            'password' => $this->computeHash($password),
        );
        try {
            Db::insert('users', $user);
        }
        catch (PDOException $ex)
        {
            throw new UserException('This username has already been taken.');
        }
    }

    public function login($email, $password)
    {
        $user = Db::queryOne('
            SELECT user_id, email, name, admin, password
            FROM users 
            WHERE email = ?
        ', array($email));
        if (!$email || !password_verify($password, $user['password']))
            throw new UserException('Invalid username or password');
        $_SESSION['user'] = $user;
    }

    public function logoff()
    {
        unset($_SESSION['user']);
    }
    public function getUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
}