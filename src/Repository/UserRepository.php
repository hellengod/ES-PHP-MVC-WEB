<?php
namespace Alura\Mvc\Repository;

use Alura\Mvc\Helper\FlashMessageTraits;
use Nyholm\Psr7\Response;
use PDO;

class UserRepository
{
    use FlashMessageTraits;
    public function __construct(
        private PDO $pdo,
    ) {

    }
    public function verify($email, $password)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        $correctPassword = password_verify($password, $userData['password'] ?? '');


        if (!$correctPassword) {
            $this->addErrorMessage('Usuario ou senha invalidos');
            return new Response(302, ['Location' => '/login']);
        }

        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $stmt = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
            $stmt->bindValue(2, $userData['id']);

        }


        $_SESSION['logado'] = true;
        return new Response(302, ['Location' => '/']);
    }
}