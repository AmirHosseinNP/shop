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

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function addPicture(Request $request)
    {
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

    public function addDiscount(Request $request)
    {
        if (!$this->discount()->exists()) {
            $this->discount()->create([
                'value' => $request->get('value')
            ]);
        } else {
            $this->discount->update([
                'value' => $request->get('value')
            ]);
        }
    }

    public function updateDiscount(Request $request)
    {
        $this->discount->update([
            'value' => $request->get('value')
        ]);
    }

    public function deleteDiscount()
    {
        $this->discount->delete();
    }

    public function getCostWithDiscountAttribute()
    {
        if (!$this->discount()->exists()) {
            return $this->cost;
        }

        return $this->cost - $this->cost * $this->discount->value / 100;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount()->exists();
    }

    public function getDiscountValueAttribute()
    {
        if ($this->has_discount) {
            return $this->discount->value;
        }

        return null;
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class)
            ->withPivot(['value'])
            ->withTimestamps();
    }

    public function getPropertyValue(Property $property)
    {
        $propertyValueQuery = $this->properties()->where('property_id', $property->id);

        if (!$propertyValueQuery->exists()) {
            return null;
        }

        return $propertyValueQuery->first()->pivot->value;
    }
}
