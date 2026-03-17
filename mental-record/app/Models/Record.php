<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'counseling_date',
        'counseling_data',
    ];

    protected $casts = [
        'counseling_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(
            Disease::class,
            'disease_record',
            'record_id',
            'disease_id'
        );
    }

    public function symptoms()
    {
        return $this->belongsToMany(
            Symptom::class,
            'symptom_record',
            'record_id',
            'symptom_id'
        );
    }

    public function medicines()
    {
        return $this->belongsToMany(
            Medicine::class,
            'medicine_record',
            'record_id',
            'medicine_id'
        );
    }

    public function images()
    {
        return $this->hasMany(RecordImage::class);
    }
}
