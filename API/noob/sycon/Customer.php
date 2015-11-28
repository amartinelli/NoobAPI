<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Customer
{
    public $dp;
    public $tbname = 'Customer';
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
         * @param int $Number  {@from body}
         * @param int $Category  {@from body}
         * @param int $Points  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param int $Client_ID  {@from body}             
     *
     * @return mixed
     */
    function post($Number, $Category, $Points, $Name, $Email, $Phone, $CPhone, $Client_ID)
    {
        return $this->dp->insert($Client_ID, compact('Number', 'Category', 'Points', 'Name', 'Email', 'Phone', 'CPhone', 'Client_ID'));
    }

    /**
     * @param int    $id
     *
         * @param int $Number  {@from body}
         * @param int $Category  {@from body}
         * @param int $Points  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param int $Client_ID  {@from body}
     *
     * @return mixed
     */
    function put($id, $Number, $Category, $Points, $Name, $Email, $Phone, $CPhone, $Client_ID)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Number', 'Category', 'Points', 'Name', 'Email', 'Phone', 'CPhone', 'Client_ID'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Number  {@from body}
         * @param int $Category  {@from body}
         * @param int $Points  {@from body}
         * @param string $Name  {@from body}
         * @param string $Email  {@from body}
         * @param string $Phone  {@from body}
         * @param string $CPhone  {@from body}
         * @param int $Client_ID  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Number = null, $Category = null, $Points = null, $Name = null, $Email = null, $Phone = null, $CPhone = null, $Client_ID = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Number)) {
                        $patch['Number'] = $Number;
                        $modified = true;
                    }

                
                    if (isset($Category)) {
                        $patch['Category'] = $Category;
                        $modified = true;
                    }

                
                    if (isset($Points)) {
                        $patch['Points'] = $Points;
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

                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
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

