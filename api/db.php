<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=bquiz03";

    protected $pdo;
    protected $table;

    // 建立建構式
    public function __construct($table)
    {
        $this->table = $table;
        // 指定物件裡面的某個變數使用 $this
        // 本機端設定
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    function all($where = '', $other = '')
    {
        $sql = "select * from `$this->table` ";
        $sql = $this->sql_all($sql,$where,$other);
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    }
    
    function count($where = '', $other = '')
    {
        $sql = "select count(*) from `$this->table` ";
        $sql = $this->sql_all($sql, $where, $other);
        return $this->pdo->query($sql)->fetchColumn();
    }
    private function math($math, $col, $array = '', $other = '')
    {
        $sql = "select sum(`$col`) from `$this->table` ";
        $sql = $this->sql_all($sql, $array, $other);
        return $this->pdo->query($sql)->fetchColumn();
    }

    function sum($col='',$where = '', $other = '')
    {
        return $this->math('sum', $col, $where, $other);
    }

    function max($col='',$where = '', $other = '')
    {
        return $this->math('max', $col, $where, $other);
    }

    function min($col='',$where = '', $other = '')
    {
        return $this->math('min', $col, $where, $other);
    }


    function find($id)
    {
        $sql = "select * from `$this->table` ";

        // 判斷是否為陣列
        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where `id`='$id'";
        }
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


    function save($array)
    {
        if (isset($array['id'])) {
            $sql = "update `$this->table` set ";

            if (!empty($array)) {
                $tmp = $this->a2s($array);
            } 

            $sql .= join(",", $tmp);
            $sql .= " where `id`='{$array['id']}'";
        } else {
            $sql = "insert into `$this->table` ";
            $cols = "(`" . join("`,`", array_keys($array)) . "`)";
            $vals = "('" . join("','", $array) . "')";

            $sql = $sql . $cols . " values " . $vals;
        }

        return $this->pdo->exec($sql);
    }

    function del($id)
    {
        $sql = "delete from `$this->table` where ";

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= "`id`='$id'";
        } 

        return $this->pdo->exec($sql);
    }
    function q($sql)
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    private function a2s($array)
    {
        foreach ($array as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        return $tmp;
    }

    private function sql_all($sql,$array,$other){

        if (isset($this->table) && !empty($this->table)) {
    
            if (is_array($array)) {
    
                if (!empty($array)) {
                    $tmp = $this->a2s($array);
                    $sql .= " where " . join(" && ", $tmp);
                }
            } else {
                $sql .= " $array";
            }
    
            $sql .= $other;
            // echo 'all=>'.$sql;
            // $rows = $this->pdo->query($sql)->fetchColumn();
            return $sql;
        }
    }

}
function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
function to($url){
    header("location:$url");
}

$sess=[1=>'1400~1600',
        2=>'1600~1800',
        3=>'1800~2000',
        4=>'2000~2200',
        5=>'2200~2400',];
$Poster=new DB('poster');
$Movie=new DB('movie');
$Order=new DB('orders');


?>
