<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ZipArchive;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'download_count'];
    public function isLinkExpired()
    {
        $expirationDate = $this->created_at->addWeek();
        return Carbon::now()->greaterThan($expirationDate);
    }
    public function getExpirationDate()
    {
        $expirationDate = $this->created_at->addWeek()->toDateString();
        return $expirationDate;
    }
    // public function getSizeInMegabytesAttribute()
    // {
    //     $sizeInBytes = $this->attributes['size'];
    //     $sizeInMegabytes = $sizeInBytes / 1048576; 
    //     $sizeInKilobytes = $sizeInBytes / 1024; 
    //     switch (true) {
    //         case $sizeInMegabytes >= 1:
    //             $formattedSize = number_format($sizeInMegabytes, 2) . ' MB';
    //             break;
    //         case $sizeInKilobytes >= 1:
    //             $formattedSize = number_format($sizeInKilobytes, 2) . ' KB';
    //             break;
    //         default:
    //             $formattedSize = $sizeInBytes . ' bytes';
    //     }

    //     return $formattedSize;
    // }
    public static function createZip($uploadedFiles, $zipFileName)
    {
        if (empty($uploadedFiles)) {
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE) !== true) {
            return false;
        }

        foreach ($uploadedFiles as $file) {
            $file = public_path('uploads/' . $file);
            if (file_exists($file)) {
                $zip->addFile($file, basename($file));
            }
        }

        $zip->close();

        return true;
    }
}
