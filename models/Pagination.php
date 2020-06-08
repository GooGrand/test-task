<?php

class Pagination
{
    public $page = 0;
    public $per_page = 2;
    public function getCurPage()
    {
        $cur_page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 0)
            $cur_page = $_GET['page'];
        return $cur_page;
    }

    public function getPage()
    {
        $db = new SafeMySql();
        $cur_page = $this->getCurPage();
        $start = ($cur_page - 1) * $this->per_page;
        $sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM `users` LIMIT ?i, ?i";
        return $data = $db->getAll($sql, $start, $this->per_page);
    }
    public function getRows()
    {
        $db = new SafeMySql();
        $rows = $db->getOne("SELECT FOUND_ROWS()");
        #Проблема заключается в этой функции, потому что она выдает 0, из за которого нет цикла while
        return $num_pages = ceil($rows / $this->per_page);
    }
}