<?php

class User {
    private PDO $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function login(string $email, string $password): ?array {
        $stmt = $this->conn->prepare("SELECT id, name, password FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}