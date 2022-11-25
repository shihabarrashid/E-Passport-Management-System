<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    //Relationship with Document
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
