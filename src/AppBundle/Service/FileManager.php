<?php

namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $path = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $path);
        return $path;
    }

    public function generateNewPath($oldPath)
    {
        list($oldName, $oldExt) = explode('.', $oldPath);
        return md5(uniqid()).'.'.$oldExt;
    }

    public function cloneFile($fileName)
    {
        $orig_file = explode('.', $fileName);
        $newFileName = md5(uniqid()) . '.' . $orig_file[1];
        if(!copy($this->targetDir . '/' . $fileName, $this->targetDir . '/' . $newFileName))
        {
            return null;
        }
        else
        {
            return $newFileName;
        }
    }

    public function delete($fileName)
    {
        unlink($this->targetDir . '/' . $fileName);
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}