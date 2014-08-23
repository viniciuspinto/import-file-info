<?php

namespace Codense\ImportFileInfo\Test;

class IntegrationTest extends \PHPUnit_Framework_TestCase {

    public function testImport() {

        $db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $db->query('DELETE FROM files;');

        $importer = new \Codense\ImportFileInfo\Importer($db);
        $importer->verbose = FALSE;
        $importer->importDir(Dir1Fixture::PATH);

        $result = $db->query("SELECT parent_path, file_name, extension, bytes FROM files;");
        $files = Dir1Fixture::getFiles();

        $this->assertEquals(8, $result->num_rows);
        $this->assertSame($files, $result->fetch_all());

    }

}


