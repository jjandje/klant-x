<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	use CrudTrait;
	use Sluggable;
	use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'recipes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
	protected $fillable = ['title', 'slug', 'image', 'content', 'preparation', 'ingredients', 'goal_id', 'category_id', 'user_id'];
    // protected $hidden = [];
    // protected $dates = [];
	protected $casts = [
		'ingredients' => 'array',
	];

	public static function boot()
	{
		parent::boot();
		self::deleting(function($recipe) {
			$recipe->goals()->detach();
			$recipe->categories()->detach();
		});
	}

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
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
	public function goals()
	{
		return $this->belongsToMany(Goal::class, 'goal_recipe');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_recipe');
    }

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_recipe');
    }

	public function author()
	{
		return $this->belongsTo(BackpackUser::class, 'user_id', 'id');
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

    public function getDishNames()
    {
        return count($this->dishes) > 0 ? implode(', ', $this->dishes->pluck('title')->all()) : '';
    }

    public function getDishClasses()
    {
	    return count($this->dishes) > 0 ? implode(' ', array_map(function($dish) { return 'dish-'.$dish; }, $this->dishes->pluck('slug')->all())) : '';
    }

	public function getGoalNames()
	{
		return count($this->goals) > 0 ? implode(', ', $this->goals->pluck('title')->all()) : '';
	}

	public function getGoalsHTML()
	{
	    $count = count($this->goals);
	    if($count === 0) return '';
	    if($count === 1) {
	    	// return string met "Doel: {Doelnaam}"
		    return '<p>'.implode('', $this->goals->pluck('title')->all()).'</p>';
	    } else {
	    	// return string met "Doelen" met een tooltip van de doelen
		    $goals = $this->goals->pluck('title')->all();
		    $goalTitles = [];
		    foreach($goals as $goal) {
		    	$goalTitles[] = $goal;
		    }
		    return '<p title="'.implode(', ', $goalTitles).'">Doelen</p>';
	    }
	}

	public function getGoalClasses()
	{
		return count($this->goals) > 0 ? implode(' ', array_map(function($goal) { return 'goal-'.$goal; }, $this->goals->pluck('slug')->all())) : '';
	}

	public function getCategories()
	{
		return count($this->categories) > 0 ? $this->categories->pluck('title')->all() : '';
	}

	public function getCategoryNames()
	{
		return count($this->categories) > 0 ? implode(', ', $this->categories->pluck('title')->all()) : '';
	}

	public function getCategoriesHTML()
	{
		$count = count($this->categories);
		if($count === 0) return '';
		if($count === 1) {
			// return string met "Doel: {Doelnaam}"
			return '<p>'.implode('', $this->categories->pluck('title')->all()).'</p>';
		} else {
			// return string met "Doelen" met een tooltip van de doelen
			$categories = $this->categories->pluck('title')->all();
			$categoryTitles = [];
			foreach($categories as $goal) {
				$categoryTitles[] = $goal;
			}
			return '<p title="'.implode(', ', $categoryTitles).'">Categorieën</p>';
		}
	}

	public function getCategorySlug()
	{
		return $this->category->slug;
	}

	public function getCategoryClasses()
	{
		return count($this->categories) > 0 ? implode(' ', array_map(function($cat) { return 'cat-'.$cat; }, $this->categories->pluck('slug')->all())) : '';
	}

	public function getAuthorName()
	{
		return $this->author->userInfo->name ?? '-';
	}

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	public function setImageAttribute($value)
	{
		$attribute_name = 'image';
		$disk = 'uploads';
		$destination_path = 'images/recipes';

		if (starts_with($value, 'data:image')) {
			// 0. Get image extension
			preg_match("/^data:image\/(.*);base64/i", $value, $match);
			if(key_exists( 1, $match)) {
				$extension = $match[1];
			} else {
				$extension = 'jpg';
			}
			// 1. Make the image
			$image = \Image::make($value);
			if (!is_null($image)) {
				// 2. Generate a filename.
				$filename = md5($value.time()).'.'.$extension;

				try {
					// 3. Store the image on disk.
					\Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
					// 4. Save the path to the database
					$this->attributes[$attribute_name] = $destination_path.'/'.$filename;
				} catch (\InvalidArgumentException $argumentException) {
					// 3. failed to save file
					\Alert::error($argumentException->getMessage())->flash();
					// 4. set as null when fail to save the image to disk
					$this->attributes[$attribute_name] = null;
				}
			}
		} else {
			$this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
		}
	}

	public function getSlugOrTitleAttribute()
	{
		if ($this->slug != '') {
			return $this->slug;
		}

		return $this->title;
	}
}
