<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'disease',
        'disease_summary',
    ];

    /**
     * 病名に紐づくカルテ（多対多）
     */
    public function records()
    {
        return $this->belongsToMany(
            Record::class,
            'disease_record',
            'disease_id',
            'record_id'
        )->withTimestamps();
    }
}
