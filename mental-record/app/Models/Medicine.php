<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine',
        'product_name',
        'category',
        'efficacy',
    ];

    /**
     * 薬品に紐づくカルテ（多対多）
     */
    public function records()
    {
        return $this->belongsToMany(
            Record::class,
            'medicine_record',
            'medicine_id',
            'record_id'
        )->withTimestamps();
    }
}
