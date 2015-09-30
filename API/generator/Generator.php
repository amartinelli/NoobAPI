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

    /**
     * @param int $id
     *
     * @return array
     */
    function get($id)
    {
        $r = $this->dp->get($id);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @status 201
     *
     * @param string $name  {@from body}
     * @param string $email {@type email} {@from body}
     *
     * @return mixed
     */
    function post($name, $email)
    {
        return $this->dp->insert(compact('name', 'email'));
    }

    /**
     * @param int    $id
     * @param string $name  {@from body}
     * @param string $email {@type email} {@from body}
     *
     * @return mixed
     */
    function put($id, $name, $email)
    {
        $r = $this->dp->update($id, compact('name', 'email'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int    $id
     * @param string $name  {@from body}
     * @param string $email {@type email} {@from body}
     *
     * @return mixed
     */
    function patch($id, $name = null, $email = null)
    {
        $patch = $this->dp->get($id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        if (isset($name)) {
            $patch['name'] = $name;
            $modified = true;
        }
        if (isset($email)) {
            $patch['email'] = $email;
            $modified = true;
        }
        if (!$modified) {
            throw new RestException(304); //not modified
        }
        $r = $this->dp->update($id, $patch);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    function delete($id)
    {
        return $this->dp->delete($id);
    }
}

