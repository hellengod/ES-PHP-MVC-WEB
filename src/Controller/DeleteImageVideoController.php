<?php
declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTraits;
use Alura\Mvc\Repository\VideoRepository;

class DeleteImageVideoController implements Controller
{
    use FlashMessageTraits;
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->addErrorMessage('Erro ao deletar video');
            header('Location: /');
            return;
        }
        $success = $this->videoRepository->removeImg($id);
        if ($success === false) {
            $this->addErrorMessage('Erro ao deletar video');
            header('Location: /');
        } else {
            header('Location: /');
        }

    }
}