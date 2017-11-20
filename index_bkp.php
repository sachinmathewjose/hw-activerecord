<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

//definition for connection
define('DATABASE', 'sj555');
define('USERNAME', 'sj555');
define('PASSWORD', 'mYSZqqZ9S');
define('CONNECTION', 'sql2.njit.edu');

class dbConn {
    protected static $db;

    private function __construct() {

        try {
            self::$db = new PDO( 'mysql:host='.CONNECTION.';dbname='.DATABASE,USERNAME,PASSWORD);
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }
    }

    static function getconnection() {
        if(!self::$db) {
            new dbConn();
        }
        return self::$db;
    }
}


//class collection
class collection
{
    static public function findAll()
    {
        $db = dbConn::getconnection();
        $tablename = get_called_class();
        $sql = 'SELECT * FROM ' . $tablename;
        $statment = $db->prepare($sql);
        $statment->execute();
        $class = static::$modelName;
        $statment->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordset = $statment->fetchAll();
        return $recordset;
    }

    static public function findOne($id)
    {

        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE `id`=' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet = $statement->fetchAll();
        return $recordsSet[0];
    }
}

class accounts extends collection {
        protected static $modelName = 'account';
}
class todos extends collection {
    protected static $modelName = 'todo';
}

class model {
    protected $tableName;
    public function save() {
        if ($this->id == '') {
            $sql = $this->insert();
        } else {
             $sql = $this->update();
        }
        try {
            $db = dbConn::getConnection();
            $statement = $db->prepare($sql);
            $statement->execute();
        }
        catch (Exception $exception) {
            echo "Connection Error: ". $exception->getMessage();
        }
    }
    public function insert() {
        $array = get_object_vars($this);
        $count = 0;
        $columnArrey;
        $valueArrey;
        foreach ($array as $key=>$value) {
            if (isset($value) && $key!='tableName') {
                $columnArrey[$count] = "`$key`";
                $valueArrey[$count] = "\"$value\"";
                $count++;
            }
        }
        $columnString = implode(',', $columnArrey);
        $valueString = implode(',', $valueArrey);
        $sql = "INSERT INTO `$this->tableName` (" . $columnString . ") VALUES (" .$valueString.")";
        echo 'I just inserted a record' . $this->id . $sql;
        return $sql;
    }

    public function update() {
        $array = get_object_vars($this);
        $updatevalue;
        $count = 0;
        foreach ($array as $key=>$value) {
            if ($key != 'id' && $value!=NULL && $key!='tableName') {
                $updatevalue[$count] = "`$key` = \"$value\"";
                $count++;
            }
        }
        $updatestring = implode (',',$updatevalue);
        $sql = "UPDATE `$this->tableName` SET ". $updatestring . " WHERE id=".$this->id;
        echo 'I just updated record:' . $this->id . $sql;
        return $sql;
    }

    public function delete() {
        $sql = 'DELETE FROM `' . $this->tableName .'` WHERE `id` =' . $this->id;
        echo 'I just deleted record' . $this->id. $sql;
        try {
            $db = dbConn::getConnection();
            $statement = $db->prepare($sql);
            $statement->execute();
        }
        catch (Exception $exception) {
            echo "Connection Error: ". $exception->getMessage();
        }
    }
}

class account extends model {
    public $id;
    public $email;
    public $fmane;
    public $lname;
    public $phone;
    public $birthday;
    public $gender;
    public $password;

    public function __construct()
    {
        $this->tableName = 'accounts';
    }
}

class todo extends model {
    public $id;
    public $owneremail;
    public $ownerid;
    public $createdate;
    public $duedate;
    public $message;
    public $isdone;

    public function __construct()
    {
        $this->tableName = 'todos';
    }
}


//$records = accounts::findAll();

//$records1 = todos::findAll();
$records = todos::findOne(8);
$records->delete();
/*$record = new todo();
$record->message = 'some task';
$record->isdone = 0;
$record->save();
*/
//print_r($record);
//print_r($records);*/
?>

