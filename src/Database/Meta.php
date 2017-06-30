<?php

namespace LaravelDocumentedMeta\Database;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Meta
 * @package LaravelDocumentedMeta\Database
 */
class Meta extends Model
{
    protected $table = 'documented_meta';

    protected $fillable = [
        'subject_id',
        'type',
        'key'
    ];
}