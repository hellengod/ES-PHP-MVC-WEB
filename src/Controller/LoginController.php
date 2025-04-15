<?php
namespace Alura\Mvc\Controller;

use PDO;
class LoginController implements Controller
{
    private PDO $pdo;
    public function __construct()
    {
        $dbPath = __DIR__ . '/../../banco.sqlite';
        $this->pdo = new PDO("sqlite:$dbPath");
    }
    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $correctPassword = password_verify($password, $userData['password'] ?? '');
        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $stmt = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $stmt->bindValue(2, $userData['id']);

        }

        if ($correctPassword) {
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            $_SESSION['error_message'] = 'Usuario ou senha invalidos';
            header('Location: /login');

        }
    }
}