<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

//Class to load classes
Class Manage 
{
    public static function autoload($class)
    {
        include 'class/'.$class.'.class.php';
    }
}

//register auto load function
spl_autoload_register(array('Manage','autoload'));
class accounts extends collection {
        protected static $modelName = 'account';
}
class todos extends collection {
    protected static $modelName = 'todo';
}

class account extends model {
    public $id;
    public $email;
    public $fname;
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
    public $createddate;
    public $duedate;
    public $message;
    public $isdone;

    public function __construct()
    {
        $this->tableName = 'todos';
    }
}

$obj = new main();
//main class
class main
{
    public function __construct()
    {
        $html = '';
        $html .= '<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body>';
        $html .= '<h1>Hw- Active record</h1><br>Printing the TODO table';
        $html .= '<hr><hr>';


        //TODO table
        $html .= '<h2>Select One Record</h2>';
        $table = todos::findOne(1);
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Select all Record</h2>';
        $table = todos::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Insert a record</h2>';
        $html .= "";
        $record = todos::create();
        $record->message = 'Created a new todo for testing';
        $record->isdone = 0;
        $html .= "todos-> message:$record->message  isdone:$record->isdone";
        $id = $record->save();
        $table = todos::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Update a record</h2>';
        $record = todos::findOne($id)[0];
        $record ->isdone = 1;
        $record ->save();
        $html .= "todos-> isdone:$record->isdone";
        $table = todos::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Delete a record</h2>';
        $record = todos::findOne($id)[0];
        $record ->delete();
        $html .= "Deleted the record : id= $id";
        $table = todos::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        //ACCOUNTs table
        $html .= '<br><br><br>Printing the ACCOUNT table';
        $html .= '<hr><hr>';
        $html .= '<h2>Select One Record</h2>';
        $table = accounts::findOne(2);
        $html .= tablecreate::htmltable_assarrey($table);
        $html .= '<h2>Select all Record</h2>';
        $table = accounts::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Insert a record</h2>';
        $html .= "";
        $record = accounts::create();
        $record->fname = 'example name';
        $record->email = 'exapmle@example.com';
        $record->password = '12345';
        $html .= "accounts-> fname:$record->fname, email:$$record->email, password:$record->password";
        $id = $record->save();
        $table = accounts::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Update a record</h2>';
        $record = accounts::findOne($id)[0];
        $record->password = '987654321';
        $record ->save();
        $html .= "accounts-> password:$record->password";
        $table = accounts::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '<h2>Delete a record</h2>';
        $record = accounts::findOne($id)[0];
        $record ->delete();
        $html .= "Deleted the record : id= $id";
        $table = accounts::findAll();
        $html .= tablecreate::htmltable_assarrey($table);

        $html .= '</body>';
        echo $html;
    }
}

?>

