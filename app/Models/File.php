<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path', 'size', 'download_count'];
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
}
