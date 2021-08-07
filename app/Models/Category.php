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
        $l2_categories = $this->children;
        $categoriesToShow = collect([]);

        foreach ($l2_categories as $l2_category) {
            if (!$l2_category->children->all()) {
                $categoriesToShow->push($l2_category);
            }

            foreach ($l2_category->children as $l3_category) {
                $categoriesToShow->push($l3_category);
            }
        }

        $categoriesToShow = $categoriesToShow->pluck('id');

        return Product::query()->whereIn('category_id', $categoriesToShow)->get();
    }
}
