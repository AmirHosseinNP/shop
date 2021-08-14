<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\True_;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function Products()
    {
        return $this->hasMany(Product::class);
    }

    public function getAllSubcategoryProducts()
    {
        $categoriesWithProducts = collect([]);

        if ($this->products()->exists()) {
            $categoriesWithProducts->push($this->id);
        }

        foreach ($this->children as $childCategory) {
            if ($childCategory->products()->exists()) {
                $categoriesWithProducts->push($childCategory->id);
            }

            foreach ($childCategory->children as $subCategory) {
                if ($subCategory->products()->exists()) {
                    $categoriesWithProducts->push($subCategory->id);
                }
            }
        }

        return Product::query()->whereIn('category_id', $categoriesWithProducts)->get();
    }

    public function getHasChildrenAttribute()
    {
        return $this->children()->count() > 0;
    }

    public function propertyGroups()
    {
        return $this->belongsToMany(PropertyGroup::class);
    }

    public function hasPropertyGroup($title) {
        return $this->propertyGroups()
            ->where('title', $title)
            ->exists();
    }
}
