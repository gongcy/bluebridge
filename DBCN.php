<?php

/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 * 数据库连接类，DBCN
 */
/*
 * 需要开启php的pdo支持，php5.1以上版本支持
 * 实现数据库连接单例化，有三要素 静态变量、静态实例化方法、私有构造函数
 */

class DPDO
{
    private $DSN;
    private $DBUser;
    private $DBPwd;
    private $longLink;
    private $pdo;

    //私有构造函数 防止被直接实例化
    private function __construct($dsn, $DBUser, $DBPwd, $longLink = false)
    {
        $this->DSN = $dsn;
        $this->DBUser = $DBUser;
        $this->DBPwd = $DBPwd;
        $this->longLink = $longLink;
        $this->connect();
    }

    //私有 空克隆函数 防止被克隆
    private function __clone()
    {
    }

    //静态 实例化函数 返回一个pdo对象
    static public function instance($dsn, $DBUser, $DBPwd, $longLink = false)
    {
        static $singleton = array();//静态函数 用于存储实例化对象
        $singIndex = md5($dsn . $DBUser . $DBPwd . $longLink);
        if (empty($singleton[$singIndex])) {
            $singleton[$singIndex] = new self($dsn, $DBUser, $DBPwd, $longLink = false);
        }
        return $singleton[$singIndex]->pdo;
    }

    private function connect()
    {
        try {
            if ($this->longLink) {
                $this->pdo = new PDO($this->DSN, $this->DBUser, $this->DBPwd, array(PDO::ATTR_PERSISTENT => true));
            } else {
                $this->pdo = new PDO($this->DSN, $this->DBUser, $this->DBPwd);
            }
            $this->pdo->query('SET NAMES utf8');
        } catch (PDOException $e) {
            die('Error:' . $e->getMessage() . '<br/>');
        }
    }
}

/*
 *   @author  ykm
 *   @date  2015.05.12
 *   @description  database 操作实例化类
 *      默认使用 关联数据 关联映射 查询
 *      execute 语句完成后 执行 $pdoStatement->debugDumpParams() 可以查看sql语句错误
 */

class DB
{
    protected $pdo;

    public function __construct($dbType = 'mysql')
    {
        require 'config.php';
        if ($dbType == 'mysql') {
            $dsn = "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME";
        }
        $this->pdo = DPDO::instance($dsn, $DB_USER, $DB_PASSWORD);
    }

    public function fetch($sql, $searchData = array(), $dataMode = PDO::FETCH_ASSOC, $preType = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY))
    {
        if ($sql) {
            $sql .= ' limit 1';
            $pdoStatement = $this->pdo->prepare($sql, $preType);
            $pdoStatement->execute($searchData);
            return $data = $pdoStatement->fetch($dataMode);
        } else {
            return false;
        }
    }

    public function fetchAll($sql, $searchData = array(), $limit = array(0, 100), $dataMode = PDO::FETCH_ASSOC, $preType = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY))
    {
        if ($sql) {
            $sql .= ' limit ' . (int)$limit[0] . ',' . (intval($limit[1]) > 0 ? intval($limit[1]) : 10);
            //echo "$sql";
            $pdoStatement = $this->pdo->prepare($sql, $preType);
            $pdoStatement->execute($searchData);
            return $data = $pdoStatement->fetchAll($dataMode);
        } else {
            return false;
        }
    }

    public function insert($tableName, $data, $returnInsertId = false, $replace = false)
    {
        if (!empty($tableName) && count($data) > 0) {
            $sql = $replace ? 'REPLACE INTO ' : 'INSERT INTO ';
            list($setSql, $mapData) = $this->FDFields($data);
            $sql .= $tableName . ' set ' . $setSql;
            $pdoStatement = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $execRet = $pdoStatement->execute($mapData);
            return $execRet ? ($returnInsertId ? $this->pdo->lastInsertId() : $execRet) : false;
        } else {
            return false;
        }
    }

    public function update($tableName, $data, $condition, $mapData = array(), $returnRowCount = true)
    {
        if (!empty($tableName) && count($data) > 0) {
            $sql = 'UPDATE ' . $tableName . ' SET ';
            list($setSql, $mapSetData) = $this->FDFields($data);
            $sql .= $setSql;
            $mapData = array_merge($mapData, $mapSetData);
            list($where, $mapData) = $this->FDCondition($condition, $mapData);
            $sql .= $where ? ' WHERE ' . $where : '';
            //echo "$sql";
            $pdoStatement = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $execRet = $pdoStatement->execute($mapData);
            return $execRet ? ($returnRowCount ? $pdoStatement->rowCount() : $execRet) : false;
        } else {
            return false;
        }
    }

    public function exec($sql)
    {
        //echo "$sql";
        $pdoStatement = $this->pdo->prepare($sql);
        $execRet = $pdoStatement->execute(array());
        return $execRet;
    }

    public function delete($tableName, $condition, $mapData = array())
    {
        if (!empty($tableName) && $condition) {
            $sql = 'DELETE FROM ' . $tableName;
            list($where, $mapData) = $this->FDCondition($condition, $mapData);
            $sql .= $where ? ' WHERE ' . $where : '';
            $pdoStatement = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $execRet = $pdoStatement->execute($mapData);
            return $execRet;
        }
    }


    //字段关联数组处理
    public function FDFields($data, $link = ',', $judge = array(), $aliasTable = '')
    {
        $sql = '';
        $mapData = array();
        foreach ($data as $key => $value) {
            $mapIndex = ':' . ($link != ',' ? 'c' : '') . $aliasTable . $key;
            $sql .= ' ' . ($aliasTable ? $aliasTable . '.' : '') . '`' . $key . '` ' . (isset($judge[$key]) ? $judge[$key] : '=') . ' ' . $mapIndex . ' ' . $link;
            $mapData[$mapIndex] = $value;
        }
        $sql = trim($sql, $link);
        return array($sql, $mapData);
    }

    public function FDField($field, $value, $judge = '=', $preMap = 'cn', $aliasTable = '')
    {
        $mapIndex = ':' . $preMap . $aliasTable . $field;
        $sql = ' ' . ($aliasTable ? $aliasTable . '.' : '') . '`' . $field . '`' . $judge . $mapIndex;
        $mapData[$mapIndex] = $value;
        return array($sql, $mapData);
    }

    public function FDCondition($condition, $mapData)
    {
        if (is_string($condition)) {
            $where = $condition;
        } else if (is_array($condition)) {
            if ($condition['str']) {
                if (is_string($condition['str'])) {
                    $where = $condition['str'];
                } else {
                    return false;
                }
            }
            if (is_array($condition['data'])) {
                $link = $condition['link'] ? $condition['link'] : 'and';
                list($conSql, $mapConData) = $this->FDFields($condition['data'], $link, $condition['judge']);
                if ($conSql) {
                    $where .= ($where ? ' ' . $link : '') . $conSql;
                    $mapData = array_merge($mapData, $mapConData);
                }
            }
        }
        return array($where, $mapData);
    }
}

?>