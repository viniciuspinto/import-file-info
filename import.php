<?php

namespace Codense\ImportFileInfo;

require_once __DIR__ . '/config.php';

set_time_limit(0);

$paramsCount = count($argv);

if ($paramsCount < 2) {
    echo "\n    USAGE: php import.php [-s] /path/to/dir\n\n";
    echo "    -s   Silent mode\n\n";
} else {

    if ($paramsCount == 2) {
        $path = $argv[1];
        $verbose = TRUE;
    } else {
        $path = $argv[2];
        $verbose = ($argv[1] !== '-s');
    }

    $confirmation = readline("\nConfirm importing files from '" . Importer::normalizeDirPath(realpath($path)) . "'? (y/n) ");

    if (mb_strtolower($confirmation) === 'y') {

        $db = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $importer = new Importer($db);
        $importer->verbose = $verbose;

        $importer->importDir(realpath($path));

        echo sprintf("\nImported %d files from %d directories.\n", $importer->importedFilesCount, $importer->importedDirsCount);
        echo sprintf("%d files could not be saved.\n\n", $importer->importErrorsCount);


    } else {
        echo "\nNothing done.\n";
    }

}


