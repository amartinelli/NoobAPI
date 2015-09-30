<?php
namespace phpClass;
use phpClass\Generated;
use phpClass\Generated\Client;
use phpClass\Generated\Operator;
use phpClass\Generated\Commands;
use phpClass\Generated\Provider;
use phpClass\Generated\Representative;
use phpClass\Generated\Lot;
use phpClass\Generated\Product;
use phpClass\Generated\ProductValue;
use phpClass\Generated\Measure;
use phpClass\Generated\Category;

class Create 
{
    function xgenerate(){
        $DB = new Db();
        $GN = new Constructor();
        
        $cnn = $DB->connect();
        $sql = "SHOW TABLES FROM SyCON";
        $result = $DB->select($sql);

        while($row = mysql_fetch_row($result)){
            $rows[] = $row[0];
        }

        foreach($rows as $myRow) {
            $tableSQL = "SHOW COLUMNS FROM $myRow";
            $resultTable = $DB->select($tableSQL);
            while ($rowChild = mysql_fetch_assoc($resultTable)) {
                //var_dump($rowChild);die();
                $arr[$myRow][] = array($rowChild['Type'], $rowChild['Field']);
            }
        }

        $GN->generate($arr);
    }

    /**
     * This method is used for create an measure for system defaults
     *
     * @url GET measure/{name}
     */
    public function measure($name)
    {
        $Utils = new Utils();
        $Measure = new Measure();
        
        $Measure->Name = $name;
        
        if ($Measure->gravarDados()) {
            return array('Success' => true, "Msg" => "Measure inserted");
        }
        return array('Success' => false, "Msg" => "Can't insert Measure into database");
        
    }
    
    /**
     * This method is used for create a client
     *
     * @url GET client/{name}/{phone}
     */
    public function client($name='',$phone='')
    {
        $Utils = new Utils();
        //echo "<pre>";
        //echo("<br />Construindo Objeto Client<br />");
        $Client = new Client();
        
        /* Formantando Telefone */
        if (strpos($phone,'(') !== false && strpos($phone,')') !== false && strpos($phone,' ') !== false && strpos($phone,'-') !== false) {
            $phoneArr = $Utils->phoneFormatMysql($phone);
            $phone = $phoneArr['DDD'].$phoneArr['Phone'];
        }        
        
        /* Adicionando as Variaveis de Client */
        $Client->Name = $name;
        $Client->Phone = $phone;

        if($Client->gravarDados())
        {
            return array('Success' => true, "Msg" => "Client inserted");
        }

        return array('Success' => false, "Msg" => "Can't insert client into database");
    
    }

    /**
     * This method is used for create an operator
     *
     * @url GET operator/{ClientID}/{login}/{password}/{name}/{phone}/{cphone}/{email}
     */
    public function operator($ClientID, $login, $password, $name,$phone="null",$cphone="null",$email="null")
    {
        $Utils = new Utils();
        $Client = new Client();
        if($Client->findClient($ClientID)){
            $Operator = new Operator();
            
            /* Formantando Telefone */
            if (strpos($phone,'(') !== false && strpos($phone,')') !== false && strpos($phone,' ') !== false && strpos($phone,'-') !== false) {
                $phoneArr = $Utils->phoneFormatMysql($phone);
                $phone = $phoneArr['DDD'].$phoneArr['Phone'];
            }

            if (strpos($cphone,'(') !== false && strpos($cphone,')') !== false && strpos($cphone,' ') !== false && strpos($cphone,'-') !== false) {
                $cphoneArr = $Utils->phoneFormatMysql($cphone);
                $cphone = $cphoneArr['DDD'].$cphoneArr['Phone'];
            }        
            
            /* Adicionando as Variaveis de Client */
            $Operator->Client_ID    = $Client->Client_ID;
            $Operator->Login        = $login;
            $Operator->Password     = hash('sha256', $password);
            $Operator->Name         = $name;
            $Operator->Phone        = $phone;
            $Operator->CPhone       = $cphone;
            $Operator->Email        = $email;
            

            if ($Operator->gravarDados()) {
                return array('Success' => true, "Msg" => "Operator inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert operator into database");
        }
        return array('Success' => false, "Msg" => "Client not found");
    }


    /**
     * This method is used for create a command
     *
     * @url GET command/{ClientID}/{reference}/{code}
     */
    public function commands($ClientID, $reference, $code)
    {
        $Utils = new Utils();
        $Client = new Client();
        
        if($Client->findClient($ClientID)){
            $Commands = new Commands();
        
            /* Adicionando as Variaveis de Client */
            $Commands->Client_ID    = $Client->Client_ID;
            $Commands->Reference    = $reference;
            $Commands->Code         = $code;

            if ($Commands->gravarDados()) {
                return array('Success' => true, "Msg" => "Command inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert command into database");
        }
        return array('Success' => false, "Msg" => "Client not found");
    }

    /**
     * This method is used for create a Category
     *
     * @url GET category/{ClientID}/{name}
     */
    public function category($ClientID, $name)
    {
        $Utils = new Utils();
        $Client = new Client();
        
        if($Client->findClient($ClientID)){
            $Category = new Category();
        
            /* Adicionando as Variaveis de Client */
            $Category->Client_ID    = $Client->Client_ID;
            $Category->Name    = $name;

            if ($Category->gravarDados()) {
                return array('Success' => true, "Msg" => "Category inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert Category into database");
        }
        return array('Success' => false, "Msg" => "Client not found");
    }

    

    /**
     * This method is used for create an Provider
     *
     * @url GET provider/{ClientID}/{name}/{site}/{phone}/{cphone}/{address}
     */
    public function provider($ClientID, $name, $site="null", $phone="null", $cphone="null", $address="null")
    {
        $Utils = new Utils();
        $Client = new Client();

        if($Client->findClient($ClientID)){
            $Provider = new Provider();

            /* Formantando Telefone */
            if (strpos($phone,'(') !== false && strpos($phone,')') !== false && strpos($phone,' ') !== false && strpos($phone,'-') !== false) {
                $phoneArr = $Utils->phoneFormatMysql($phone);
                $phone = $phoneArr['DDD'].$phoneArr['Phone'];
            }

            if (strpos($cphone,'(') !== false && strpos($cphone,')') !== false && strpos($cphone,' ') !== false && strpos($cphone,'-') !== false) {
                $cphoneArr = $Utils->phoneFormatMysql($cphone);
                $cphone = $cphoneArr['DDD'].$cphoneArr['Phone'];
            }        

            $Provider->Client_ID = $Client->Client_ID;
            $Provider->Name = $name;
            $Provider->Site = $site;
            $Provider->Phone = $phone;
            $Provider->CPhone = $cphone;
            $Provider->Address = $address;
            
            if ($Provider->gravarDados()) {
                return array('Success' => true, "Msg" => "Provider inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert provider into database");
        }
        return array('Success' => false, "Msg" => "Client not found");
    }

    /**
     * This method is used for create a Representative
     *
     * @url GET representative/{ClientID}/{ProviderID}/{name}/{email}/{phone}/{cphone}/{ref}
     */
    public function representative($ClientID, $ProviderID, $name, $email="null", $phone="null", $cphone="null", $ref="null")
    {
        $Utils = new Utils();
        $Client = new Client();
        $Provider = new Provider();

        if($Client->findClient($ClientID) && $Provider->findProvider($ProviderID)){
            $Representative = new Representative();

            /* Formantando Telefone */
            if (strpos($phone,'(') !== false && strpos($phone,')') !== false && strpos($phone,' ') !== false && strpos($phone,'-') !== false) {
                $phoneArr = $Utils->phoneFormatMysql($phone);
                $phone = $phoneArr['DDD'].$phoneArr['Phone'];
            }

            if (strpos($cphone,'(') !== false && strpos($cphone,')') !== false && strpos($cphone,' ') !== false && strpos($cphone,'-') !== false) {
                $cphoneArr = $Utils->phoneFormatMysql($cphone);
                $cphone = $cphoneArr['DDD'].$cphoneArr['Phone'];
            }        

            $Representative->Client_ID = $Client->Client_ID;
            $Representative->Provider_ID = $Provider->Provider_ID;
            $Representative->Name = $name;
            $Representative->Email = $email;
            $Representative->Phone = $phone;
            $Representative->CPhone = $cphone;
            $Representative->Ref = $ref;
            
            if ($Representative->gravarDados()) {
                return array('Success' => true, "Msg" => "Representative inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert representative into database");
        }
        return array('Success' => false, "Msg" => "Client Or Provider not found");
    }

    /**
     * This method is used for create a Lot
     *
     * @url GET lot/{ClientID}/{ProviderID}/{Code}/{Date}/{Manufacture}/{Maturity}
     */
    public function lot($ClientID, $ProviderID, $Code, $Date="0000-00-00 00:00:00", $Manufacture="0000-00-00 00:00:00", $Maturity="0000-00-00 00:00:00")
    {
        $Utils = new Utils();
        $Client = new Client();
        $Provider = new Provider();

        if($Client->findClient($ClientID) && $Provider->findProvider($ProviderID)){
            $Lot = new Lot();

            $Lot->Client_ID = $Client->Client_ID;
            $Lot->Provider_ID = $Provider->Provider_ID;
            $Lot->Code = $Code;
            $Lot->Date = $Date;
            $Lot->Manufacture = $Manufacture;
            $Lot->Maturity = $Maturity;
            
            if ($Lot->gravarDados()) {
                return array('Success' => true, "Msg" => "Lot inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert Lot into database");
        }
        return array('Success' => false, "Msg" => "Client Or Provider not found");
    }

    /**
     * This method is used for create a Product
     *
     * @url GET product/{ClientID}/{LotID}/{MeasureID}/{CategoryID}/{Name}/{Quantity}
     */
    public function product($ClientID, $LotID, $MeasureID, $CategoryID, $Name, $Quantity)
    {
        $Utils = new Utils();
        $Client = new Client();
        $Lot = new Lot();
        $Measure = new Measure();
        $Category = new Category();

        if($Client->findClient($ClientID) 
            && $Lot->findLot($LotID) 
            && $Measure->findMeasure($MeasureID)
            && $Category->findCategory($CategoryID)){
            
            $Product = new Product();

            $Product->Client_ID = $Client->Client_ID;
            $Product->Lot_ID = $Lot->Lot_ID;
            $Product->Category = $Category->Category_ID;
            $Product->Measure_ID = $Measure->Measure_ID;
            $Product->Name = $Name;
            $Product->Quantity = $Quantity;
            
            $productReturn = $Product->gravarDados();
            if ($productReturn) {
                return array('Success' => true, "Msg" => "Product inserted", "Product_ID" => $productReturn);
            }
            return array('Success' => false, "Msg" => "Can't insert Product into database");
        }
        return array('Success' => false, "Msg" => "Client, Product or Measure not found");
    }

    /**
     * This method is used for create a Product Value
     *
     * @url GET productvalue/{ClientID}/{Product_ID}/{Value}
     */
    public function productvalue($ClientID, $Product_ID, $Value)
    {
        $Utils = new Utils();
        $Client = new Client();
        $Product = new Product();
        

        if($Client->findClient($ClientID) 
            && $Product->findProduct($Product_ID)){
            
            $ProductValue = new ProductValue();

            $ProductValue->Client_ID = $Client->Client_ID;
            $ProductValue->Product_ID = $Product->Product_ID;
            $ProductValue->Value = $Value;
            
            if ($ProductValue->gravarDados()) {
                return array('Success' => true, "Msg" => "Product Value inserted");
            }
            return array('Success' => false, "Msg" => "Can't insert Product Value into database");
        }
        return array('Success' => false, "Msg" => "Client or Product not found");
    }

}
