<?php

namespace Codense\ImportFileInfo\Test;

class Dir1Fixture {

    const PATH = __DIR__ . '/dir1/';

    public static function getFiles() {
        return array(
            [self::PATH, 'A.TXT', 'txt', '1216'],
            [self::PATH, 'b.php', 'php', '41'],
            [self::PATH, 'c.java', 'java', '0'],
            [self::PATH, 'no_extension', '', '0'],
            [self::PATH . 'others/', '567567.c', 'c', '9'],
            [self::PATH . 'others/', 'data.tar.gz', 'gz', '0'],
            [self::PATH, 'presentation.pptx', 'pptx', '0'],
            [self::PATH . 'temp/', 'some.rb', 'rb', '40']
        );
    }

}


