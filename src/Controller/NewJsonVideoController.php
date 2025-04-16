<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewJsonVideoController implements Controller
{

    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $request = file_get_contents('php:\\input');
        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $this->videoRepository->add($video);
        return new Response(201);

    }
}