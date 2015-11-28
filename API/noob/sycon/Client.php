<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Client
{
    public $dp;
    public $tbname = 'Client';
    private $ClientD = 1;

    function __construct()
    {
        $tbname = $this->tbname;
        $this->dp = new DB_PDO_MySQL($tbname);
    }
    
    /**
     * @url GET /{ClientID}
     *
     * @param int ClientID
     *
     * @return array
     */
    function index($ClientID)
    {
        return $this->dp->getAll($ClientID);
    }

    /**
     *
     * @url GET /{ClientID}/{id}
     *
     * @param int id
     * @param int ClientID
     *
     * @return array
     */
    function get($ClientID, $id)
    {
        $r = $this->dp->get($ClientID, $id);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @status 201
     *
     *
         * @param string $Name  {@from body}
         * @param string $Phone  {@from body}             
     *
     * @return mixed
     */
    function post($Name, $Phone)
    {
        return $this->dp->insert($Client_ID, compact('Name', 'Phone'));
    }

    /**
     * @param int    $id
     *
         * @param string $Name  {@from body}
         * @param string $Phone  {@from body}
     *
     * @return mixed
     */
    function put($id, $Name, $Phone)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Name', 'Phone'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param string $Name  {@from body}
         * @param string $Phone  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Name = null, $Phone = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Phone)) {
                        $patch['Phone'] = $Phone;
                        $modified = true;
                    }

                
        if (!$modified) {
            throw new RestException(304); //not modified
        }
        $r = $this->dp->update($Client_ID, $id, $patch);
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @url DELETE /{ClientID}/{id}
     *
     * @param int ClientID
     * @param int id
     *
     * @return array
     */
    function delete($ClientID, $id)
    {
        return $this->dp->delete($ClientID, $id);
    }
}

