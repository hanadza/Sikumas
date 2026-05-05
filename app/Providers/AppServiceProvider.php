<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    // FORCE HTTPS kalau environment production
    if (env('APP_ENV') === 'production') {
      URL::forceScheme('https');
    }

    // Storage symlink
    try {
      $publicStorage = public_path('storage');
      $storageAppPublic = storage_path('app/public');

      if (!file_exists($publicStorage) && is_dir($storageAppPublic)) {
        File::link($storageAppPublic, $publicStorage);
      }
    } catch (\Exception $e) {
      //
    }
  }
}
