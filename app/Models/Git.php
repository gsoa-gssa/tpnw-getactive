<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CzProject\GitPhp\Git as GH;

class Git extends Model
{
    use HasFactory;

    public $git;
    public $repo;

    public function __construct(array $attributes = []) {
        $this->git = new GH;
        $this->repo = $this->git->open(base_path());
    }

    public static function getLastCommit() {
        $git = new Git();
        try {
            return $git->repo->getLastCommit();
        } catch (\CzProject\GitPhp\GitException $e) {
            var_dump($e->getRunnerResult()->toText());
        }
    }
}
