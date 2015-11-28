<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Bill
{
    public $dp;
    public $tbname = 'Bill';
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
         * @param int $Sale_ID  {@from body}
         * @param int $History_ID  {@from body}
         * @param int $Customer_ID  {@from body}
         * @param date $Date  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Sale_ID, $History_ID, $Customer_ID, $Date)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Sale_ID', 'History_ID', 'Customer_ID', 'Date'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Sale_ID  {@from body}
         * @param int $History_ID  {@from body}
         * @param int $Customer_ID  {@from body}
         * @param date $Date  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Sale_ID, $History_ID, $Customer_ID, $Date)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Sale_ID', 'History_ID', 'Customer_ID', 'Date'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Sale_ID  {@from body}
         * @param int $History_ID  {@from body}
         * @param int $Customer_ID  {@from body}
         * @param date $Date  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Sale_ID = null, $History_ID = null, $Customer_ID = null, $Date = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Sale_ID)) {
                        $patch['Sale_ID'] = $Sale_ID;
                        $modified = true;
                    }

                
                    if (isset($History_ID)) {
                        $patch['History_ID'] = $History_ID;
                        $modified = true;
                    }

                
                    if (isset($Customer_ID)) {
                        $patch['Customer_ID'] = $Customer_ID;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
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

