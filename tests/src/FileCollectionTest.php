<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;

class FileCollectionTest extends TestCase
{
    private static $NAME_FILE_TEST = "testFile.txt";
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function objectCanBeConstructed()
    {
        $collection = new FileCollection(self::$NAME_FILE_TEST);
        return $collection;
    }

    /**
     * @test
     * @doesNotPerformAssertions
     * @depends objectCanBeConstructed
     */
    public function dataDeleteFile()
    {
        $collection = new FileCollection(self::$NAME_FILE_TEST);
        fopen(self::$NAME_FILE_TEST,'w');
        $collection->delete();
    }

    /**
     * @test
     * @depends dataDeleteFile
     * @dataProvider dataProviderTheFileCanSeRead
     */
    public function dataTheFileCanSeRead($value)
    {
        $file = fopen(self::$NAME_FILE_TEST,'w');
        fwrite($file, $value);
        fclose($file);
        $collection = new FileCollection(self::$NAME_FILE_TEST);
        $dataFile = $collection->readFile();
        $this->assertEquals($dataFile, $value);
        $collection->delete();
    }

    public function dataProviderTheFileCanSeRead()
    {
        return [
            [123],
            ["prueba"],
            [true],
            ["prueba2\n123"]
        ];
    }

    /**
     * @test
     * @depends dataTheFileCanSeRead
     * @dataProvider dataProviderTheFileCanSeWrite
     */
    public function dataTheFileCanSeWrite($data, $dataFile)
    {
        $collection = new FileCollection(self::$NAME_FILE_TEST);

        foreach ($data as $key => $value) {
            $collection->set($key, $value);
        }
        $collection->writesFile();
        $dataFile = $collection->readFile();
        $this->assertEquals($dataFile, $dataFile);
        $collection->delete();
    }

    public function dataProviderTheFileCanSeWrite()
    {
        $dataCollectionVoid = [];
        $dataFileVoid = null;
        $dataCollection = [
            "index1" => 123,
            "index2" => "456",
            "index3" => true,
        ];
        $dataFile = "123\n56\n1";
        return [
            [$dataCollectionVoid, $dataFileVoid],
            [$dataCollection, $dataFile]
        ];
    }
}