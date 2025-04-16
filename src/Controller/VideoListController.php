<?php
namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->all();

        echo $this->renderTamplate('video-list', ['videoList' => $videoList]);
    }
}