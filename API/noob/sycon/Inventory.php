<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Inventory
{
    public $dp;
    public $tbname = 'Inventory';
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
         * @param int $Product_ID  {@from body}
         * @param string $Codebar  {@from body}
         * @param int $Quantity  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Product_ID, $Codebar, $Quantity)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Product_ID', 'Codebar', 'Quantity'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Product_ID  {@from body}
         * @param string $Codebar  {@from body}
         * @param int $Quantity  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Product_ID, $Codebar, $Quantity)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Product_ID', 'Codebar', 'Quantity'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Product_ID  {@from body}
         * @param string $Codebar  {@from body}
         * @param int $Quantity  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Product_ID = null, $Codebar = null, $Quantity = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Product_ID)) {
                        $patch['Product_ID'] = $Product_ID;
                        $modified = true;
                    }

                
                    if (isset($Codebar)) {
                        $patch['Codebar'] = $Codebar;
                        $modified = true;
                    }

                
                    if (isset($Quantity)) {
                        $patch['Quantity'] = $Quantity;
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

