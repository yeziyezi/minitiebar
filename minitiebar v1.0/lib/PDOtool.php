<?php
class PDOtool
{
    private $dsn = 'mysql:host=host;dbname=miniTieBar';
    private $db_username = "db_username";
    private $db_password = "db_password";
    private $pdo=null;
    function __construct(){
        $this->pdo = new PDO($this->dsn, $this->db_username, $this->db_password);
        ($this->pdo)->setAttribute (PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );

    }
    function query($query, $param_array = null)
    {
        $pdo=&$this->pdo;
        $stmt = null;
        //预处理
        if ($param_array !== null) {
            $stmt = $pdo->prepare($query);
            foreach ($param_array as $k => $v) {
                $stmt->bindValue($k, $v);
            }
            $stmt->execute();
        } else {
            $stmt = $pdo->query($query);
        }

        return $stmt;
    }
    function getResultArray($query, $param_array = null)
    {
        $stmt = $this->query($query, $param_array);
        if($stmt===false){
            return null;
        }else{
            return $stmt->fetch();
        }
        
    }
    //得到结果数组中的某个特定字段值——前提数组是一维，即查询只查出一行数据,否则会出错
    function getOne($query, $param_name, $param_array = null)
    {
        $result_array = $this->getResultArray($query, $param_array);
        return $result_array[$param_name];
    }
    //分页查询
    function queryByPage(string $query, $pagenum, $pagesize,array $params=NULL)
    {
        $startIndex = ($pagenum - 1) * $pagesize;
        $endIndex = $pagenum * $pagesize - 1;
        $query = "$query limit $startIndex,$endIndex";
        $stmt=$this->query($query,$params);
        return $stmt->fetchAll();
    }
    
    function destroy(){
        //  断开连接
        $this->pdo=null;
    }
        //事务处理

    function transaction($query_array,$param_array){
        $pdo=&$this->pdo;
        $pdo->beginTransaction();
        foreach($query_array as $query){
            if(strpos($query,':')===FALSE){//非预处理语句
                 $pdo->exec($query);
            }else{
                //预处理
                $stmt=$pdo->prepare($query);
                foreach($param_array as $k=>$v){
                    //将当前预处理语句中的值绑定
                    if(strpos($query,$k)!==FALSE){
                        $stmt->bindValue($k,$v);
                    }
                }
                 $stmt->execute();
            }
        }
        
         $pdo->commit();
    }
}