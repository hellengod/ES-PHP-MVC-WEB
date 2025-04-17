<?php
namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTraits;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
class LoginController implements RequestHandlerInterface
{
    use FlashMessageTraits;
    private PDO $pdo;
    public function __construct()
    {
        $dbPath = __DIR__ . '/../../banco.sqlite';
        $this->pdo = new PDO("sqlite:$dbPath");
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parseBody = $request->getParsedBody();

        $email = filter_var($parseBody['email'], FILTER_VALIDATE_EMAIL);

        $password = filter_var($parseBody['password']);

        $repository = new UserRepository($this->pdo);
        return $repository->verify($email, $password);

    }
}