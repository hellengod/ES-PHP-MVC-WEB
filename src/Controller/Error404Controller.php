<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Error404Controller implements Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {

        $html = '<h1>Página não encontrada (Erro 404)</h1>';

        return new Response(
            404,
            ['Content-Type' => 'text/html'],
            $html
        );
    }
}