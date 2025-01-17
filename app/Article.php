<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'content', 'topic'
    ];
}
