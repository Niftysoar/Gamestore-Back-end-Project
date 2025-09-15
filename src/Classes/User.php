<?php

class User {
    private PDO $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function register(string $name, string $email, string $password): bool {
        // Vérifier si l'email existe déjà
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->fetch()) {
            return false; // Email déjà utilisé
        }

        // Insérer l'utilisateur
        $stmt = $this->conn->prepare(
            "INSERT INTO users (name, email, password, created_at) 
             VALUES (:name, :email, :password, NOW())"
        );

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
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