<?php

namespace Codense\ImportFileInfo;

class Importer {

    public $skipFiles = ['.DS_Store'];
    public $verbose = TRUE;
    public $db = NULL;

    // Stats
    public $importedDirsCount = 0;
    public $importedFilesCount = 0;
    public $importErrorsCount = 0;

    public function __construct($db) {
        $this->db = $db;
    }

    public function importDir($dirPath) {
        $this->processFiles($dirPath, $this->getFileList($dirPath));
    }

    public function processFiles($dirPath, $fileNames) {
        $this->importedDirsCount++;
        $dirPath = self::normalizeDirPath($dirPath);
        $this->printStatus("Processing ".count($fileNames)." file(s) from $dirPath");
        foreach ($fileNames as $fileName) {
            if (is_dir($dirPath . $fileName)) {
                $this->importDir($dirPath . $fileName);
            } else {
                $size = (int) filesize($dirPath . $fileName);
                if ($this->saveFileToDatabase($dirPath, $fileName, $this->getExtension($fileName), $size)) {
                    $this->importedFilesCount++;
                } else {
                    $this->importErrorsCount++;
                }
            }
        }
    }

    public function saveFileToDatabase($dirPath, $fileName, $extension, $size) {
        $query = $this->db->prepare("INSERT INTO files (parent_path, file_name, extension, bytes, full_path_hash) VALUES (?, ?, ?, ?, ?);");
        $fullPathHash = md5($dirPath . $fileName);
        $query->bind_param('sssds', $dirPath, $fileName, $extension, $size, $fullPathHash);
        $result = $query->execute();
        if (!$result) {
            $this->printStatus($query->error);
        }
        $query->close();
        return $result;
    }

    public function getExtension($fileName) {
        $dot = mb_strrpos($fileName, '.');
        return ($dot !== FALSE ? mb_strtolower(mb_substr($fileName, $dot + 1)) : '');
    }

    public function getFileList($dirPath) {
        $fileList = array();
        try {
            if ($handle = opendir($dirPath)) {
                while (false !== ($fileName = readdir($handle))) {
                    if ($fileName != '.' && $fileName != '..' && !in_array($fileName, $this->skipFiles)) {
                        $fileList[] = $fileName;
                    }
                }
                closedir($handle);
            }
        } catch (\Exception $e) {
            $this->printStatus($e->getMessage());
        }
        sort($fileList);
        return $fileList;
    }

    public static function normalizeDirPath($dirPath) {
        $dirPath = rtrim($dirPath, '\\');
        if (mb_substr($dirPath, -1) !== '/') {
            $dirPath .= '/';
        }
        return $dirPath;
    }

    private function printStatus($status) {
        if ($this->verbose) {
            echo "\n$status\n";
        }
    }

}


