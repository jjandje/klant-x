<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	use CrudTrait;
	use Sluggable;
	use SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
	protected $fillable = ['title', 'slug', 'content', 'image', 'user_id', 'goal_id'];
    // protected $hidden = [];
    // protected $dates = [];

	public static function boot()
	{
		parent::boot();
		self::deleting(function($article) {
			$article->goals()->detach();
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
	public function goals(  ) {
		return $this->belongsToMany(Goal::class, 'article_goal');
    }

	public function author(  ) {
		return $this->belongsTo(BackpackUser::class, 'id', 'id');
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
	public function getGoalNames() {
		return count($this->goals) > 0 ? implode(', ', $this->goals->pluck('title')->all()) : '';
	}

	public function getGoalClasses()
	{
		return count($this->goals) > 0 ? implode(' ', array_map(function($goal) { return 'goal-'.$goal; }, $this->goals->pluck('slug')->all())) : '';
	}

	public function getAuthorName() {
		return $this->author->userInfo->name ?? '';
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
		$destination_path = 'images/articles';

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
