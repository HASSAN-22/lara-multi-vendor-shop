<?php

namespace App\Auxiliary\Uploader;

use function App\Auxiliary\removeFile;

class Upload{

    private function __construct(){}

    /**
     * Add timestamp to prev file name
     *
     * @param $file
     * @return string
    */
    private static function getName($file): string{
        $Microtime = explode(' ',microtime())[0];
        $Microtime = last(explode('.', $Microtime));
        return $Microtime.'-'.$file->getClientOriginalName();
    }


    /**
     * Move file to directory
     *
     * @param $file
     * @param string $directory
     * @return string
    */

    private static function move($file, string $directory): string{
        $path = $file->store($directory);
        return str_replace('uploader/','',$path);
    }

    /**
     * Upload file if file dose not exist
     *
     * @param $request
     * @param string $key
     * @param string $directory
     * @param string|null $lastPath
     * @param string|null $index
     * @return string|null
    */
    public static function upload($request, string $key, string $directory, string $lastPath='', string $index=''){

        if( $request->hasFile($key) ){
            $file = $index == '' ? $request->file($key) : $request->file($key)[$index];
            return "/storage/".static::move($file, $directory);
        }
        return empty($lastPath) ? null : $lastPath;
    }
}
