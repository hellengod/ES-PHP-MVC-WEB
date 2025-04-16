<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTraits;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class EditVideoController implements Controller
{
    use FlashMessageTraits;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();

        $id = filter_var($requestBody['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErrorMessage('Id inválido');
            return new Response(302, ['Location' => '/']);
        }

        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('URL inválida');
            return new Response(302, ['Location' => '/']);
        }

        $titulo = filter_var($requestBody['titulo']);
        if ($titulo === false || empty($titulo)) {
            $this->addErrorMessage('Título inválido');
            return new Response(302, ['Location' => '/']);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        // Upload de imagem usando UploadedFileInterface
        $files = $request->getUploadedFiles();
        if (isset($files['image'])) {
            /** @var UploadedFileInterface $uploadedImage */
            $uploadedImage = $files['image'];
            if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
                $mimeType = $finfo->file($tmpFile);

                if (str_starts_with($mimeType, 'image/')) {
                    $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                    $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                    $video->setFilePath($safeFileName);
                } else {
                    $this->addErrorMessage('Arquivo enviado não é uma imagem válida');
                    return new Response(302, ['Location' => '/']);
                }
            }
        }

        $success = $this->videoRepository->update($video);
        if ($success === false) {
            $this->addErrorMessage('Erro ao editar vídeo');
        }

        return new Response(302, ['Location' => '/']);
    }
}
