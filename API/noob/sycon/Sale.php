<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Sale
{
    public $dp;
    public $tbname = 'Sale';
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
         * @param int $Commands_ID  {@from body}
         * @param int $Payment_ID  {@from body}
         * @param date $Date  {@from body}
         * @param string $Value  {@from body}
         * @param int $Operator_ID  {@from body}
         * @param int $Cashier_ID  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Commands_ID, $Payment_ID, $Date, $Value, $Operator_ID, $Cashier_ID)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Commands_ID', 'Payment_ID', 'Date', 'Value', 'Operator_ID', 'Cashier_ID'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Commands_ID  {@from body}
         * @param int $Payment_ID  {@from body}
         * @param date $Date  {@from body}
         * @param string $Value  {@from body}
         * @param int $Operator_ID  {@from body}
         * @param int $Cashier_ID  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Commands_ID, $Payment_ID, $Date, $Value, $Operator_ID, $Cashier_ID)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Commands_ID', 'Payment_ID', 'Date', 'Value', 'Operator_ID', 'Cashier_ID'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Commands_ID  {@from body}
         * @param int $Payment_ID  {@from body}
         * @param date $Date  {@from body}
         * @param string $Value  {@from body}
         * @param int $Operator_ID  {@from body}
         * @param int $Cashier_ID  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Commands_ID = null, $Payment_ID = null, $Date = null, $Value = null, $Operator_ID = null, $Cashier_ID = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Commands_ID)) {
                        $patch['Commands_ID'] = $Commands_ID;
                        $modified = true;
                    }

                
                    if (isset($Payment_ID)) {
                        $patch['Payment_ID'] = $Payment_ID;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
                        $modified = true;
                    }

                
                    if (isset($Value)) {
                        $patch['Value'] = $Value;
                        $modified = true;
                    }

                
                    if (isset($Operator_ID)) {
                        $patch['Operator_ID'] = $Operator_ID;
                        $modified = true;
                    }

                
                    if (isset($Cashier_ID)) {
                        $patch['Cashier_ID'] = $Cashier_ID;
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

