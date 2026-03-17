<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nickname',
        'age',
        'sex',
        'occupation',
    ];

    /**
     * クライエントは複数のカルテを持つ
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    // ネームマスク
    public function getMaskedNameAttribute()
    {
        $name = $this->name;
        $len = mb_strlen($name);

        if ($len <= 1) {
            return $name;
        }

        if ($len == 2) {
            return mb_substr($name,0,1) . '＊';
        }

        return mb_substr($name,0,1) . str_repeat('＊',$len-2) . mb_substr($name,-1);
    }

}
