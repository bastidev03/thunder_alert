<?php
namespace App\Lib;

use FilesystemIterator;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class CsvReader
{
    private $file_resource;

    //Absolute path
    private $file_path;

    public function __construct(string $file_path)
    {
        $file_system = new Filesystem();
        if(!$file_system->isAbsolutePath($file_path))
        {
            $file_path = Path::makeAbsolute($file_path, __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');
        }

        if(!$file_system->exists($file_path)) {
            throw new \Exception("File ($file_path) not found");
        }

        if(is_dir($file_path)) {
            throw new \Exception("File ($file_path) is not a file");
        }

        $file_extension = Path::getExtension($file_path, true);
        if($file_extension !== 'csv') {
            throw new \Exception("File ($file_path) is not a csv file");
        }

        $this->file_path = $file_path;

        $this->file_resource = fopen($file_path, 'r');
        if($this->file_resource === false) {
            throw new \Exception("Failed reading file ($file_path)");
        }
    }

    public function __destruct()
    {
        if($this->file_resource) {
            fclose($this->file_resource);
        }
    }

    public function getArray()
    {
        $array = fgetcsv($this->file_resource, 1000, ";");
        if($array === false) {
            throw new \Exception("Fail reading ({$this->file_path}) CSV file");
        }

        return $array;
    }
}