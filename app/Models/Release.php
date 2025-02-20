<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'user_id',
            'document_id',
            'documenttype_id',
            'file',
        ];
}
