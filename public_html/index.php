<?php

require '../classes/Drink.php';

$getset = new Drink();
$getset ->setName('Kazkoks');
$getset ->setAbarot(32);
var_dump($getset);

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
        if ($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
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

    public function truncateTable($table_name)
    {
        if ($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
    }

    public function insertRow($table_name, $row, $row_id = null)
    {
        if ($this->tableExists($table_name)) {
            if ($row_id) {
                $this->data[$table_name][$row_id] = $row;
            } else {
                $this->data[$table_name][] = $row;
            }

            return true;
        }

        return false;
    }

    public function rowExists($table_name, $row_id)
    {
        if (isset($this->data[$table_name][$row_id])) {
            return true;
        }
        return false;
    }

    /**
     * Jeigu toks $row_id jau egzistuoja table,
     * return'inti false'ą, kitu atveju įtraukti
     * eilutę ir return'inti true;
     * @param string $table_name
     * @param string $row
     * @param string $row_id
     * @return boolean
     */
    public function rowInsertIfNotExists($table_name, $row, $row_id)
    {
        if (!$this->rowExists($table_name, $row_id)) {
            $this->insertRow($table_name, $row, $row_id);
            return true;
        }

        return false;
    }

    /**
     * Perrašo eilutę $data'os $table $row_id
     * indeksu su $row array'jum, jeigu ji
     * egzistuoja
     * @param string $table
     * @param string $row_id
     * @param string $row
     */
    public function updateRow($table_name, $row_id, $row)
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        }

        return false;
    }


    /**
     * 9uzd Ištrina eilutę $data'os $table $row_id
     * indeksu
     * @param string $table_name
     * @param integer $row_id
     */
    public function deleteRow($table_name, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        }
        return false;
    }

    /**
     * 10uzd Paima row-Id jeigu rowExist
     * @param string $table_name
     * @param $row_id
     * @return mixed
     */
    public function getRow($table_name, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            return $this->data[$table_name][$row_id];
        }
        return false;
    }


    /**
     * 11uzd Grazina eilute $data'os $table pagal tai, kokius condition'us nurodeme: Pvz: ['name' => 'Mantas'];
     * @param string $table_name
     * @param array $conditions
     */

    public function getRowsWhere($table_name, $conditions) {
        $rows = [];
        foreach ($this->data[$table_name] as $row_id => $row) {
            $conditions_met = true;
            foreach ($conditions as $col_id => $cond_value) {
                $row_value = $row[$col_id];
                if ($row_value != $cond_value) {
                    $conditions_met = false;
                    break;
                }
            }
            if ($conditions_met) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

}

//$row = [
//        'name' => 'Mantas'
//];


//$newObject = new FileDB('text.txt');
//$newObject -> createTable('tabelis');
//$newObject -> insertRow('tabelis', 'pirmas');
//$newObject -> insertRow('tabelis', 'antras');
//$newObject -> insertRow('tabelis', 'treciA');
//var_dump($newObject->getRowsWhere('rowid', $row));
//var_dump($newObject);

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