<?php

class User{
    private $conn;
    private $table = "users";

    public $id;
    public $name;
    public $email;
    public $phone;
    public $pwd;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO" . $this->table . "(name, email, phone, pwd, role)
                  VALUES (:name, :email, :pwd, :role)";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->pwd = password_hash($this->pwd, PASSWORD_DEFAULT);
        $this->role = $this->role ?? "user";

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":pwd", $this->pwd);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()){
            $this->id = $this->lastInsertId();
            return true;
        }

        return false;
    }

    public function login() {
        $query = "SELECT FROM" . $this->table . " WHERE name = :name LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name, $this->name");
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
        (name, email, phone, pwd, role)
        VALUES(:name, :email, :phone, :pwd, :role)";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $this->bindParam(":phone", $this->phone);
        $this->bindParam(":pdw", $this->pwd);
        $this->bindParam(":role", $this->role);

        return $stmt->execute();
    }
}