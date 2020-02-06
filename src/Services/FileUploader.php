<?php

namespace App\Services;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function uploadFile(UploadedFile $file)
    {
        $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
        // Move file to uploads
        $file->move(
            $this->container->getParameter('uploads_dir'),
            $filename
        );

        return $filename;
    }
}