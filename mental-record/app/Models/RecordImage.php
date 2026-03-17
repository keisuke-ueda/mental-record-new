<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordImage extends Model
{
    use HasFactory;

    protected $table = 'record_images';

    protected $fillable = [
        'record_id',
        'image_path',
    ];

    public $timestamps = false;

    /**
     * 画像は1つのカルテに属する
     */
    public function record()
    {
        return $this->belongsTo(Record::class);
    }
}
