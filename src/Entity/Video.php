<?php
namespace Alura\Mvc\Entity;

use InvalidArgumentException;

class Video
{
    public readonly string $url;
    public readonly int $id;
    private ?string $filePath = null;
    
    public function __construct(
        string $url,
        public readonly string $title,
    ) {
        $this->setUrl($url);
        $this->filePath = null;
    }
    

    private function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }
}
