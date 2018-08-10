<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 10/08/18
 * Time: 00:57
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private $public_directory;

    public function __construct($public_directory)
    {
        $this->public_directory = $public_directory;
    }

    public function upload(UploadedFile $file, $targetDirectory){
        $fileName = ($this->generateUniqueFileName().'.'.$file->guessExtension());
        $file->move($this->public_directory.$targetDirectory, $fileName);

        return $fileName;
    }

    private function generateUniqueFileName(){
        return md5(uniqid());
    }
}