<?php
namespace generator;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;
//use DB_Session;

class Generator
{
    public $dp;

    function __construct()
    {
        $this->dp = new DB_PDO_MySQL();
    }

    function index()
    {
        $GN = new Constructor();
        $string = '';

        foreach($this->dp->getAllTables() as $row){
            foreach($row as $value){ 
            $rows[] = $value;
            $string .= '$r->addAPIClass(\'noob\\sycon\\'.$value.'\');';
            } 
        }

        foreach($rows as $myRow) {
            $resultTable = $this->dp->getAllColumns($myRow);
            foreach($resultTable as $rowChild){
                $type = explode("(",$rowChild['Type']);
                $type = ($type[0] == 'datetime') ? 'date' : $type[0];
                $type = ($type == 'varchar') ? 'string' : $type;
                $arr[$myRow][] = array( 'Type' => $type, 'Field' => $rowChild['Field']);
            }
        }

        if($GN->generate($arr)) return $string;
    }
}

