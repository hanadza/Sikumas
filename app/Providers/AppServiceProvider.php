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
    // AUTO BUAT SYMLINK STORAGE KALAU BELUM ADA
    try {
      $publicStorage = public_path('storage');
      $storageAppPublic = storage_path('app/public');

      if (!file_exists($publicStorage) && is_dir($storageAppPublic)) {
        File::link($storageAppPublic, $publicStorage);
      }
    } catch (\Exception $e) {
      // Abaikan error symlink agar app tidak crash
    }
  }
}
