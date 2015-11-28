<?php
namespace generator;
use Luracast\Restler\RestException;

class Constructor 
{
    var $classKey = 0;

    function generate($dataTables)
    {
        try{
            foreach($dataTables as $table => $data){
                $this->classKey = 0;
                $class = $this->createClass($table, $data);
                $this->createFile($table.".php", $class);
            }
            return true;
        }catch(\Exception $e){
            die('Code Exception: <br />'.$e);
        }
        return false;
    }

    function createFile($fileName, $txt, $prefix = '../noob/sycon/'){
        $prefix = (__DIR__)."/".$prefix;
        try{
            $myfile = fopen($prefix.$fileName, "w") or die("Unable to open file!");
            fwrite($myfile, $txt);
            fclose($myfile);
        }catch(\Exception $e){
            die('Code Exception: <br />'.$e);
        }
    }

    function createClass($table, $data)
    {
        $labels = '';
        $fields = '';
        $patchs = '';
        $patchsCode = '';
        $funclb = '';
        $i = 0;
        foreach($data as $tableData){
            if($i>0){
                $fields .= '
         * @param '.$tableData['Type'].' $'.$tableData['Field'].'  {@from body}';
                $patchs .=   ', ';
                $patchs .=   '$'.$tableData['Field'].' = null';
                
                if($i>1){
                    $funclb .=   ', ';
                    $labels .=   ', ';
                }   
                $funclb .=   '$'.$tableData['Field'];
                $labels .=   '\''.$tableData['Field'].'\'';
                
                $patchsCode .= '
                    if (isset($'.$tableData['Field'].')) {
                        $patch[\''.$tableData['Field'].'\'] = $'.$tableData['Field'].';
                        $modified = true;
                    }

                ';

            }
            $i++;
        }

        $classTXT = '<?php
namespace noob\sycon;
use Luracast\Restler\RestException;
use DB_PDO_MySQL;

class '.$table.'
{
    public $dp;
    public $tbname = \''.$table.'\';
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
     *'.$fields.'             
     *
     * @return mixed
     */
    function post('.$funclb.')
    {
        return $this->dp->insert($Client_ID, compact('.$labels.'));
    }

    /**
     * @param int    $id
     *'.$fields.'
     *
     * @return mixed
     */
    function put($id, '.$funclb.')
    {
        $r = $this->dp->update($Client_ID, $id, compact('.$labels.'));
        if ($r === false)
            throw new RestException(404);
        return $r;
    }

    /**
     * @param int $id
     *'.$fields.'
     *
     * @return mixed
     */
    function patch($id'.$patchs.')
    {
        $patch = $this->dp->get($Client_ID, $id);
        if ($patch === false)
            throw new RestException(404);
        $modified = false;
        '.$patchsCode.'
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

';
        return $classTXT;
    }
}

?>
