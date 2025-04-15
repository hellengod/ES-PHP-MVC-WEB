<?php
namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController extends ControllerWithHtml implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->all();

        echo $this->renderTamplate('video-list', ['videoList' => $videoList]);
    }
}