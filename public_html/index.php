<?php

class FileDB
{
    private $file_name;
    private $data;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function load()
    {
        if (file_exists($this->file_name)) {
            $encoded_string = file_get_contents($this->file_name);

            if ($encoded_string !== false) {
                $this->data = json_decode($encoded_string, true);
            }
        }
    }

    public function getData()
    {
        if ($this->data == null) {
            $this->load();
        }
        return $this->data;
    }

    public function setData($data_array)
    {
        $this->data = $data_array;
    }

    public function save()
    {
        $json_string = json_encode($this->data);
        $success = file_put_contents($this->file_name, $json_string);
        if ($success !== FALSE) {
            return true;
        } else {
            return false;
        }
    }

    public function createTable($table_name)
    {
        if ($this->tableExists($table_name)){
            return false;
        } else {
            $this->data[$table_name] = [];
            return true;
        }
    }

    public function dropTable($table_name)
    {
        unset($this->data[$table_name]);
    }

    public function tableExists($table_name)
    {
        if (isset($this->data[$table_name])) {
            return true;
        } else {
            return false;
        }
    }
}

$newObject = new FileDB('text.txt');
var_dump($newObject);

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To PHP FightClub!</title>
    <link rel="stylesheet" href="media/css/normalize.css">
    <link rel="stylesheet" href="media/css/style.css">
</head>
<body>
</body>
</html>