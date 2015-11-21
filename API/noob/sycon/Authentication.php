<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Authentication
{
    /*
    public $dp;
    public $tbname = 'Bill';
    */

    function __construct()
    {
        //$tbname = $this->tbname;
        //$this->dp = new DB_PDO_MySQL($tbname);
    }

    function index()
    {
        //return $this->dp->getAll();
    }

    /**
     * @status 202
     *
     *
     * @param string $Email  {@from body}
     * @param string $Password  {@from body}
     *
     * @return mixed
     */
    function post($Email, $Password)
    {
        $operator = new Operator();
        $loggedUser = $operator->postLogin($Email,$Password);
        return $loggedUser;
        //$ArrayFields = array($Email,$Password);
        //return $arrayFields;
    }

    
}

        