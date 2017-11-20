<?php 
abstract class collection
{
	static public function create() {
      $model = new static::$modelName;
      return $model;
    }
    static public function getlastid() {
    	$sql = 'SELECT LAST_INSERT_ID()';
    	
    }
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
        return $recordsSet;
    }
}

?>