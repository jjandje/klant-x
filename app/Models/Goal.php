<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use CrudTrait;
	use Sluggable;
	use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'goals';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
	protected $fillable = ['title', 'slug', 'image', 'content', 'workbook', 'duration'];
    // protected $hidden = [];
    // protected $dates = [];

	public static function boot()
	{
	    parent::boot();
	    self::deleting(function($goal) {
	    	$goal->articles()->detach();
	    	$goal->recipes()->detach();
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
	public function articles(  ) {
		return $this->belongsToMany(Article::class, 'article_goal');
//		return $this->hasMany(Article::class, 'goal_id', 'id');
    }

	public function recipes(  ) {
		return $this->belongsToMany(Recipe::class, 'goal_recipe');
//		return $this->hasMany( Recipe::class,'goal_id', 'id');
    }

	public function users(  ) {
		return $this->belongsToMany(BackpackUser::class, 'goal_user')
		            ->using(UserGoal::class)
		            ->withPivot([
			            'active',
			            'start_date',
			            'finish_date',
		            ])
		            ->withTimestamps();
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
	public function getArticleNames() {
		return implode(', ', $this->articles->pluck('title')->all());
    }
	public function getRecipeNames() {
		return implode(', ', $this->recipes->pluck('title')->all());
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
		$destination_path = 'images/goals';

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

	public function setWorkbookAttribute( $value ) {
		$attribute_name = 'workbook';
		$disk = 'uploads';
		$destination_path = 'pdf/goals';

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
