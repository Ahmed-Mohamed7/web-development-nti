<?php
class Connection
{
    private $host;
    private $dbName;
    private $dbUser;
    private $dbPass;
    private $conn;

    function __construct(
        $host='localhost',
        $dbName='group11blog',
        $dbUser='root',
        $dbPass='ahmed')
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;

        $this->conn =  mysqli_connect($this->host, $this->dbUser, $this->dbPass, $this->dbName);

        if (!$this->conn)
            echo mysqli_connect_error();
    }

    ## for both insert and delelte 
    function doQuery($sql)
    {

        $op = mysqli_query($this->conn, $sql);

        if ($op)
            return  true;

        return false;
    }

    function doQuerySelect($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = [];
        while ($raw = mysqli_fetch_assoc($result)) {
            $data[] = $raw;
        }
        return $data;
    }

    function __destruct()
    {
        mysqli_close($this->conn);
    }
}
