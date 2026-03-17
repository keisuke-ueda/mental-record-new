<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'symptom',
        'symptom_summary',
    ];

    /**
     * 症状に紐づくカルテ（多対多）
     */
    public function records()
    {
        return $this->belongsToMany(
            Record::class,
            'symptom_record',
            'symptom_id',
            'record_id'
        )->withTimestamps();
    }
}
