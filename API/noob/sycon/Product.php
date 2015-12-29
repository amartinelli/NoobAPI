<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class Product
{
    public $dp;
    public $tbname = 'Product';
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
     * @param int ClientID
     * @param int id
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
     *
     * @url GET /Search/{ClientID}/{name}
     *
     * @param int ClientID
     * @param string name
     *
     * @return array
     */
    function search($ClientID, $name)
    {
        return $this->dp->getByName($ClientID, $name);
    }

    /**
     * @status 201
     *
     *
         * @param int $Client_ID  {@from body}
         * @param int $Lot_ID  {@from body}
         * @param string $Name  {@from body}
         * @param int $Category  {@from body}
         * @param int $Measure_ID  {@from body}
         * @param string $Quantity  {@from body}             
     *
     * @return mixed
     */
    function post($Client_ID, $Lot_ID, $Name, $Category, $Measure_ID, $Quantity)
    {
        return $this->dp->insert($Client_ID, compact('Client_ID', 'Lot_ID', 'Name', 'Category', 'Measure_ID', 'Quantity'));
    }

    /**
     * @param int    $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Lot_ID  {@from body}
         * @param string $Name  {@from body}
         * @param int $Category  {@from body}
         * @param int $Measure_ID  {@from body}
         * @param string $Quantity  {@from body}
     *
     * @return mixed
     */
    function put($id, $Client_ID, $Lot_ID, $Name, $Category, $Measure_ID, $Quantity)
    {
        $r = $this->dp->update($Client_ID, $id, compact('Client_ID', 'Lot_ID', 'Name', 'Category', 'Measure_ID', 'Quantity'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *
         * @param int $Client_ID  {@from body}
         * @param int $Lot_ID  {@from body}
         * @param string $Name  {@from body}
         * @param int $Category  {@from body}
         * @param int $Measure_ID  {@from body}
         * @param string $Quantity  {@from body}
     *
     * @return mixed
     */
    function patch($id, $Client_ID = null, $Lot_ID = null, $Name = null, $Category = null, $Measure_ID = null, $Quantity = null)
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Lot_ID)) {
                        $patch['Lot_ID'] = $Lot_ID;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Category)) {
                        $patch['Category'] = $Category;
                        $modified = true;
                    }

                
                    if (isset($Measure_ID)) {
                        $patch['Measure_ID'] = $Measure_ID;
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

