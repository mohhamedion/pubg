<?php

namespace App\Helpers;

use File;
use Storage;

class Folder
{
    /**
     * Check folder existence.
     *
     * @param string $dir
     * @return void
     */
    public static function checkDirectory(string $dir): void
    {
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 493, true);
        }
    }

    /**
     * Check local storage folder existence.
     *
     * @param string $dir
     * @return void
     */
    public static function checkStorageDirectory(string $dir): void
    {
        $directories = Storage::directories($dir);
        if (empty($directories)) {
            Storage::makeDirectory($dir);
        }
    }
}
