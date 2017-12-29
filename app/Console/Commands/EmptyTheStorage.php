<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EmptyTheStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty the local filesystem';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->backupFiles();
        $this->clearPublicDir();
        $this->restoreFiles();
    }

    /**
     * Backup files
     */
    protected function backupFiles()
    {
        $default_avatar_path =  $this->getAvatarPath();
        Storage::disk('local')->copy($default_avatar_path, 'default.png');
    }

    /**
     * Get the default avatar path
     *
     * @return string
     */
    protected function getAvatarPath()
    {
        return 'public' . DS . 'avatars' . DS . 'default.png';
    }

    /**
     * Delete the public directory
     */
    protected function clearPublicDir()
    {
        Storage::disk('local')->deleteDirectory("public");
        Storage::disk('local')->makeDirectory("public");
    }

    /**
     * Restore the backup files
     */
    protected function restoreFiles()
    {
        $default_avatar_path = $this->getAvatarPath();

        Storage::disk('local')->move("default.png", $default_avatar_path);
    }
}
