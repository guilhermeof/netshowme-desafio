<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'name',
        'mime',
        'extension',
        'location'
    ];

    public static function fileUri($attachmentsId)
    {
        return route('file.show', ['id' => $attachmentsId]);
    }
}
