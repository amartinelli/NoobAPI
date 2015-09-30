<?php

/**
 * MySQL DB. All data is stored in data_pdo_mysql database
 * Create an empty MySQL database and set the dbname, username
 * and password below
 *
 * This class will create the table with sample data
 * automatically on first `get` or `get($id)` request
 */
use Luracast\Restler\RestException;

class DB_PDO_MySQL
{
    private $db;
    private $tbname;

    function __construct($tbname = '')
    {
        $this->tbname = $tbname;
        try {
            //Make sure you are using UTF-8
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            //Update the dbname username and password to suit your server
            $this->db = new PDO(
                    'mysql:host=localhost;dbname=SyCONHOMOLOGA',
                    'root',
                    'root',
                    $options
                    );
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC);

            //If you are using older version of PHP and having issues with Unicode
            //uncomment the following line
            //$this->db->exec("SET NAMES utf8");

        } catch (PDOException $e) {
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    } 
 
    function getAllTables($installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt = $this->db->query('SHOW TABLES');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            if (!$installTableOnFailure && $e->getCode() == '42S02') {
                //SQLSTATE[42S02]: Base table or view not found: 1146 Table 'authors' doesn't exist
                $this->install();
                return $this->getAll(TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }

    function getAllColumns($tbname, $installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt = $this->db->query('SHOW COLUMNS FROM '.$tbname);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            if (!$installTableOnFailure && $e->getCode() == '42S02') {
                //SQLSTATE[42S02]: Base table or view not found: 1146 Table 'authors' doesn't exist
                $this->install();
                return $this->getAll(TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }

    function get($id, $installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = $this->db->prepare('SELECT * FROM '.$this->tbname.' WHERE '.$this->tbname.'_ID = :id');
            $sql->execute(array(':id' => $id));
            return $this->id2int($sql->fetch());
        } catch (PDOException $e) {
            if (!$installTableOnFailure && $e->getCode() == '42S02') {
                //SQLSTATE[42S02]: Base table or view not found: 1146 Table 'authors' doesn't exist
                $this->install();
                return $this->get($id, TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }

    function getAll($installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt = $this->db->query('SELECT * FROM '.$this->tbname);
            return $this->id2int($stmt->fetchAll());
        } catch (PDOException $e) {
            if (!$installTableOnFailure && $e->getCode() == '42S02') {
                //SQLSTATE[42S02]: Base table or view not found: 1146 Table 'authors' doesn't exist
                $this->install();
                return $this->getAll(TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }

    function insert($rec)
    {
        $fieldSelect = '';
        $fieldLabel = '';
        $fieldArray = array();
        $numItems = count($rec);
        $i = 0;
        foreach($rec as $key=>$value) {
            $i++;
            $fieldArray[':'.$key]    = $value; 
            $fieldSelect    .= $key; 
            $fieldLabel     .= ":".$key; 
            $fieldSelect    .= ($i === $numItems) ? '' : ', '; 
            $fieldLabel     .= ($i === $numItems) ? '' : ', '; 
        }   

        $sql = $this->db->prepare("INSERT INTO ".$this->tbname." (".$fieldSelect.") VALUES (".$fieldLabel.")");
        if (!$sql->execute($fieldArray))
            return FALSE;
        return $this->get($this->db->lastInsertId());
    }

    function update($id, $rec)
    {
        $fieldLabel = '';
        $fieldArray = array(':id' => $id);
        $numItems = count($rec);
        $i = 0;
        foreach($rec as $key=>$value) {
            $i++;
            $fieldArray[':'.$key]    = $value; 
            $fieldLabel     .= $key." = :".$key; 
            $fieldLabel     .= ($i === $numItems) ? '' : ', '; 
        } 
        $sql = $this->db->prepare("UPDATE ".$this->tbname." SET ".$fieldLabel." WHERE ".$this->tbname."_ID = :id");
        if (!$sql->execute($fieldArray))
            return FALSE;
        return $this->get($id);
    }

    function delete($id)
    {
        $r = $this->get($id);
        if (!$r || !$this->db->prepare('DELETE FROM '.$this->tbname.' WHERE '.$this->tbname.'_ID = ?')->execute(array($id)))
            return FALSE;
        return $r;
    }

    private function id2int($r)
    {
        $tbname = $this->tbname;
        if (is_array($r)) {
            if (isset($r[$tbname.'_ID'])) {
                $r[$tbname.'_ID'] = intval($r[$tbname.'_ID']);
            } else {
                foreach ($r as &$r0) {
                    $r0[$tbname.'_ID'] = intval($r0[$tbname.'_ID']);
                }
            }
        }
        return $r;
    }

    private function install()
    {
        /*
           $this->db->exec(
           "CREATE TABLE authors (
           id INT AUTO_INCREMENT PRIMARY KEY ,
           name TEXT NOT NULL ,
           email TEXT NOT NULL
           ) DEFAULT CHARSET=utf8;"
           );
           $this->db->exec(
           "INSERT INTO authors (name, email) VALUES ('Jac  Wright', 'jacwright@gmail.com');
           INSERT INTO authors (name, email) VALUES ('Arul Kumaran', 'arul@luracast.com');"
           );
         */
    }
}

