<?php
class Database{

    public $conn;

    public $assetsUrl = "https://app.weboin.com/api/users/assets/";
    public $adminAssetsUrl = "https://app.weboin.com/admin/images/";

    // public $apiUsername = "weboin";
    // public $apiPassword = "M^@^3JuqYpYJX3/q<?Fd'Fk}&z]~Q";

    // get the database connection
    public function getConnection(): ?mysqli
    {

        // if($this->apiUsername == $authUsername && $this->apiPassword == $authPassword){

            $this->conn = new mysqli("localhost:3306", "adminuser1", "6392RND8Cuxt", "weboin");
            return $this->conn;

        // }
        return null;
    }
}
?>