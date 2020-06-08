<?php

class Db
{
    private static $connection;

    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function connect($host, $user, $password, $database)
    {
        if (!isset(self::$connection))
        {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings
            );
        }
    }

    public static function queryOne($query, $params = array())
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetch();
    }

    public static function queryAll($query, $params = array())
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetchAll();
    }
    public static function querySingle($query, $params = array())
    {
        $result = self::queryOne($query, $params);
        if (!$result)
            return false;
        return $result[0];
    }

    // Executes a query and returns the number of affected rows
    public static function query($query, $params = array())
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->rowCount();
    }
    public static function insert($table, $params = array())
    {
        return self::query("INSERT INTO `$table` (`".
            implode('`, `', array_keys($params)).
            "`) VALUES (".str_repeat('?,', sizeof($params)-1)."?)",
            array_values($params));
    }

    public static function update($table, $values = array(), $condition, $params = array())
    {
        return self::query("UPDATE `$table` SET `".
            implode('` = ?, `', array_keys($values)).
            "` = ? " . $condition,
            array_merge(array_values($values), $params));
    }

}