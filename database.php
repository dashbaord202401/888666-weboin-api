<?php
class Database{

    public $conn;
    public $assetsUrl = "https://app.weboin.com/api/users/assets/";
    public $adminAssetsUrl = "https://app.weboin.com/admin/images/";

    // get the database connection
    public function getConnection(): ?mysqli
    {
        $this->conn = new mysqli("localhost:3306", "adminuser1", "6392RND8Cuxt", "weboin");
        // $this->conn = new mysqli("localhost", "root", "root", "web");
        return $this->conn;
    }
}
?>