<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    +   S3 Structure:

    +   /brands/
    +   /users/
    +   /products/
    +       |
    +       |___{brand_slug}/
    +               |
    +               |___ 400/

    +       |___{brand_slug}/
    +               |
    +               |___ 400/

    +       .  .  .  .  

    */

    /*
    +
    +   #################################
    +   STORAGE METHODS
    +   #################################

    +   always define Storage::disk('s3')
    

    +   About files:

    +   files($dir) - lists all files in a dir
    +   allFiles($dir) - lists all files in a dir, recursively
    +   get($file) - Retrieve a file
    +   exists($file) - Return if file exists or not
    +   url($file) - Get the full qualified URL to the file
    +   size($file) - get file size
    +   lastModified($file) - get UNIX timestamp of upload
    +   copy($oldFile, $newFile) - copy a file
    +   move($oldSpace, $newSpace) - move a file
    +   delete($file) or delete($filesArray[]) - delete file(s)
    
    +   upload a file on S3:
    +
    +   $path = $request->file('image')->store(
            '/{dirs}/{filename}', 's3'
        );

    +   About directories:

    +   directories($di) - lists all dirs in a dir
    *   allDirectories($dir) - lists all dirs in a dir, recursively
    +   makeDirectory($dir) - create directory and needed subdirectories
    +   deleteDirectory($dir) - delete directory and subdirectories
    +
    */

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY', 'AKIAJX5TP7TCMW6WNZJQ'),
            'secret' => env('AWS_SECRET', '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'),
            'region' => env('AWS_REGION', 'eu-central-1'),
            'bucket' => env('AWS_BUCKET', 'enea-gestionale'),
        ],

    ],

];
