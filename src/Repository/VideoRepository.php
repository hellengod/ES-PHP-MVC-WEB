<?php
namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;

class VideoRepository
{


    public function __construct(
        private PDO $pdo,
    ) {

    }

    public function add(Video $video): bool
    {
        $sql = 'INSERT INTO videos (url, title, image_path) VALUES (?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $video->url);
        $stmt->bindValue(2, $video->title);
        $stmt->bindValue(3, $video->getFilePath());
        $result = $stmt->execute();
        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));
        return $result;
    }

    public function remove(int $id): bool
    {
        $sql = "DELETE FROM videos WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    } 
       public function removeImg(int $id): bool
    {
        $sql = "UPDATE videos SET image_path = NULL WHERE id = ?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    public function update(Video $video): bool
    {
        $updateImageSql = '';

        if ($video->getFilePath() !== null) {
            $updateImageSql = ', image_path = :image_path';
        }

        $sql = "UPDATE videos SET
         url= :url,
         title= :title
         $updateImageSql
         WHERE id = :id;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':url', $video->url);
        $stmt->bindValue(':title', $video->title);
        $stmt->bindValue(':id', $video->id, PDO::PARAM_INT);

        if ($video->getFilePath() !== null) {
            $stmt->bindValue(':image_path', $video->getFilePath());
        }

        return $stmt->execute();

    }

    /**
     * @return Video[]
     */

    public function all(): array
    {
        $videoList = $this->pdo->query('SELECT * FROM videos;')
            ->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        if ($videoData['image_path'] !== null) {
            $video->setFilePath($videoData['image_path']);
        }
        return $video;
    }




}