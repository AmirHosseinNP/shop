<?php

namespace App\Models;

use App\Helpers\ConvertNumbers;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCommentDateAttribute()
    {
        return Verta::instance($this->updated_at)->format('Y/n/j');
    }
}
