<?php
declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTraits;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteImageVideoController implements Controller
{
    use FlashMessageTraits;
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMessage('Id Invalido');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        $success = $this->videoRepository->removeImg($id);
        if ($success === false) {
            $this->addErrorMessage('Erro ao deletar video');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }

    }
}