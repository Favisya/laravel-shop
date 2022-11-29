<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Info
{
    public $tittle;
    public $date;
    public $body;

    public function __construct($tittle, $date, $body)
    {
        $this->tittle = $tittle;
        $this->date   = $date;
        $this->body   = $body;
    }

    public static function all()
    {
        return cache()->rememberForever('info.all', function () {
            return  collect(File::files(resource_path('info/')))
                ->map(fn($file) => \Spatie\YamlFrontMatter\YamlFrontMatter::parseFile($file))
                ->map(fn($document) =>new \App\Models\Info(
                    $document->tittle,
                    $document->date,
                    $document->body()
                )
                )->sortByDesc('date');
        });
    }

    public static function find($slug)
    {
        $path = resource_path("/info/{$slug}.html");

        if (!file_exists($path)) {
            Throw new ModelNotFoundException();
        }

        return cache()->remember("bio.{$slug}", 3, function() use($path) {
            $document = \Spatie\YamlFrontMatter\YamlFrontMatter::parseFile($path);
            return new Info(
                $document->tittle,
                $document->date,
                $document->body()
            );
        });
    }
}
