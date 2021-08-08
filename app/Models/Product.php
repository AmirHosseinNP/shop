<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function addPicture(Request $request) {
        $path = $request->file('image')->storeAs(
            'public/images/products/pictures',
            $request->file('image')->getClientOriginalName()
        );

        $this->pictures()->create([
            'path' => $path,
            'mime' => $request->file('image')->getClientMimeType(),
            'size' => $request->file('image')->getSize()
        ]);
    }

    public function deletePicture(Picture $picture)
    {
        Storage::delete($picture->path);

        $picture->delete();
    }
}
