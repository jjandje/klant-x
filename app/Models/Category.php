<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Category extends Model
{
    use CrudTrait;
	use Sluggable;
	use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['title', 'slug'];
    // protected $hidden = [];
    // protected $dates = [];

	public static function boot()
	{
		parent::boot();
		self::deleting(function($category) {
			$category->recipes()->detach();
		});
	}

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'slug_or_title',
			],
		];
	}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function recipes() {
		return $this->belongsToMany(Recipe::class, 'category_recipe');
//		return $this->hasMany( Recipe::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	public function getSlugOrTitleAttribute()
	{
		if ($this->slug != '') {
			return $this->slug;
		}

		return $this->title;
	}
}
