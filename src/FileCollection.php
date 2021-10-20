<?php
namespace Live\Collection;

/**
 * File collection
 *
 * @package Live\Collection
 */
class FileCollection extends MemoryCollection
{
    /**
     * Collection file
     *
     * @var string
     */
    private $fileName;

    /**
     * Constructor
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        parent::__construct();
    }

    /**
     * @desc read file
     * @param string $defaultValue
     * @return array
     */
    public function readFile($defaultValue = null)
    {
        $data = $defaultValue;
        if ($this->fileExists()) {
            $data = file_get_contents($this->fileName);
        }
        return $data;
    }

    /**
     * @desc method for writing the dataCollection to the file
     */
    public function writesFile()
    {
        if ($this->count() > 0) {
            $file = fopen($this->fileName, 'a+');
            $text = '';
            foreach ($this->data as $data) {
                $text .= $data."\n";
            }
            fwrite($file, $text);
            fclose($file);
        }
    }

    /**
     * @desc method to check if file exists
     * @return bool
     */
    public function fileExists(): bool
    {
        return file_exists($this->fileName);
    }

    public function delete()
    {
        if($this->fileExists()) {
            unlink($this->fileName);
        }
    }
}
