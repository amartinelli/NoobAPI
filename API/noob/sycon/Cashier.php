<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Cashier
{
    public $dp;
    public $tbname = 'Cashier';
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
         * @param int $Operator_ID  {@from body}
         * @param date $Date_Start  {@from body}
         * @param date $Date_End  {@from body}
         * @param string $Value_Start  {@from body}
         * @param string $Value_End  {@from body}
         * @param string $Ref  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Operator_ID, $Date_Start, $Date_End, $Value_Start, $Value_End, $Ref)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Operator_ID', 'Date_Start', 'Date_End', 'Value_Start', 'Value_End', 'Ref'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Operator_ID  {@from body}
         * @param date $Date_Start  {@from body}
         * @param date $Date_End  {@from body}
         * @param string $Value_Start  {@from body}
         * @param string $Value_End  {@from body}
         * @param string $Ref  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Operator_ID, $Date_Start, $Date_End, $Value_Start, $Value_End, $Ref)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Operator_ID', 'Date_Start', 'Date_End', 'Value_Start', 'Value_End', 'Ref'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Operator_ID  {@from body}
         * @param date $Date_Start  {@from body}
         * @param date $Date_End  {@from body}
         * @param string $Value_Start  {@from body}
         * @param string $Value_End  {@from body}
         * @param string $Ref  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Operator_ID = null, $Date_Start = null, $Date_End = null, $Value_Start = null, $Value_End = null, $Ref = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Operator_ID)) {
                        $patch['Operator_ID'] = $Operator_ID;
                        $modified = true;
                    }

                
                    if (isset($Date_Start)) {
                        $patch['Date_Start'] = $Date_Start;
                        $modified = true;
                    }

                
                    if (isset($Date_End)) {
                        $patch['Date_End'] = $Date_End;
                        $modified = true;
                    }

                
                    if (isset($Value_Start)) {
                        $patch['Value_Start'] = $Value_Start;
                        $modified = true;
                    }

                
                    if (isset($Value_End)) {
                        $patch['Value_End'] = $Value_End;
                        $modified = true;
                    }

                
                    if (isset($Ref)) {
                        $patch['Ref'] = $Ref;
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

