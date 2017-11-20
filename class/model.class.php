<?php 
abstract class model {
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
            return $db->lastInsertId();
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
        return $sql;
    }

    public function delete() {
        $sql = 'DELETE FROM `' . $this->tableName .'` WHERE `id` =' . $this->id;
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

?>