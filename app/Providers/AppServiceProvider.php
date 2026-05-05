<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    // FIX: Auto-create storage symlink kalau belum ada atau corrupted
    $publicStorage = public_path('storage');
    $storageAppPublic = storage_path('app/public');

    if (!is_link($publicStorage)) {
      if (is_dir($publicStorage)) {
        File::deleteDirectory($publicStorage);
      }
      if (is_dir($storageAppPublic)) {
        File::link($storageAppPublic, $publicStorage);
      }
    }
  }
}
