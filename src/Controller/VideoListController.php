<?php
namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }
    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->all();

        require_once __DIR__ . '/../../View/video-list.php';
    }
}