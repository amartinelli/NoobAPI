<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Representative
{
    public $dp;
    public $tbname = 'Representative';
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
         * @param int $Client_ID  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param string $Ref  {@from body}
         * @param int $Provider_ID  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Name, $Email, $Phone, $CPhone, $Ref, $Provider_ID)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Name', 'Email', 'Phone', 'CPhone', 'Ref', 'Provider_ID'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param string $Ref  {@from body}
         * @param int $Provider_ID  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Name, $Email, $Phone, $CPhone, $Ref, $Provider_ID)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Name', 'Email', 'Phone', 'CPhone', 'Ref', 'Provider_ID'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param string $Ref  {@from body}
         * @param int $Provider_ID  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Name = null, $Email = null, $Phone = null, $CPhone = null, $Ref = null, $Provider_ID = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Email)) {
                        $patch['Email'] = $Email;
                        $modified = true;
                    }

                
                    if (isset($Phone)) {
                        $patch['Phone'] = $Phone;
                        $modified = true;
                    }

                
                    if (isset($CPhone)) {
                        $patch['CPhone'] = $CPhone;
                        $modified = true;
                    }

                
                    if (isset($Ref)) {
                        $patch['Ref'] = $Ref;
                        $modified = true;
                    }

                
                    if (isset($Provider_ID)) {
                        $patch['Provider_ID'] = $Provider_ID;
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

