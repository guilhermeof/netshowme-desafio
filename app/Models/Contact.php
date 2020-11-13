<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'ip',
        'attachment_id',
    ];

    public function attachment()
    {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
}
