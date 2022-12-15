<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetController extends Controller
{
    private $directories = ['categories', 'products'];

    public function resetProject()
    {
        Artisan::call('migrate:fresh --seed');

        foreach ($this->directories as $directory) {
            Storage::deleteDirectory($directory);
            Storage::makeDirectory($directory);

            $files = Storage::disk('reset')->files($directory);

            foreach ($files as $file) {
                Storage::put($file, Storage::disk('reset')->get($file));
            }
        }

        Session::setFlash('success', 'Проект был сброшен в начальное состояние');
        return redirect()->route('index');
    }
}
