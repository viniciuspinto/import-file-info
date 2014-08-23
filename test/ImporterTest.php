<?php

namespace Codense\ImportFileInfo\Test;

use \Codense\ImportFileInfo\Importer;

class ImporterTest extends \PHPUnit_Framework_TestCase {

    public $verbose = FALSE;

    public function setUp() {
        $this->importer = new \Codense\ImportFileInfo\Importer(true);
        $this->importer->verbose = $this->verbose;
    }

    public function testGetFileList() {
        $list = array('A.TXT', 'b.php', 'c.java', 'no_extension', 'others', 'presentation.pptx', 'temp');
        $output = $this->importer->getFileList(Dir1Fixture::PATH);
        sort($output);
        $this->assertEquals($list, $output);
    }

    public function testNormalizeDirPath() {
        $this->assertEquals('/', Importer::normalizeDirPath('/'));
        $this->assertEquals('/files/', Importer::normalizeDirPath('/files'));
        $this->assertEquals('/some/dir\ /', Importer::normalizeDirPath('/some/dir\ '));
        $this->assertEquals('/some/dir/', Importer::normalizeDirPath('/some/dir\\\\\\'));
        $this->assertEquals('C:\\Windows\\files/', Importer::normalizeDirPath('C:\\Windows\\files'));
        $this->assertEquals('C:\\Windows\\files/', Importer::normalizeDirPath('C:\\Windows\\files\\'));
        $this->assertEquals('C:\\Windows\\files/', Importer::normalizeDirPath('C:\\Windows\\files/'));
    }

    public function testImportInvalidDir() {
        $importer = $this->getMock('\Codense\ImportFileInfo\Importer', ['saveFileToDatabase'], [true]);

        $importer->expects($this->exactly(0))
                 ->method('saveFileToDatabase');

        $this->importer->importDir('nonexistent/directory/');
    }

    public function testImportDir() {
        $importer = $this->getMock('\Codense\ImportFileInfo\Importer', ['saveFileToDatabase'], [true]);
        $importer->verbose = $this->verbose;

        $importer->expects($this->exactly(8))
                 ->method('saveFileToDatabase')
                 ->withConsecutive(...Dir1Fixture::getFiles());

        $importer->importDir(Dir1Fixture::PATH);
    }

    public function testGetExtension() {
        $this->assertEquals('txt', $this->importer->getExtension('A.TXT'));
        $this->assertEquals('txt', $this->importer->getExtension('some.txt'));
        $this->assertEquals('gz', $this->importer->getExtension('multiple.tar.gz'));
        $this->assertEquals('', $this->importer->getExtension('unusual...'));
        $this->assertEquals('', $this->importer->getExtension('no_extension'));
        $this->assertEquals('space   ', $this->importer->getExtension('endswith.space   '));
        $this->assertEquals(' ', $this->importer->getExtension('endswith. '));
    }

}



