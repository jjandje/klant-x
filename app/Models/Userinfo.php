<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use crudTrait;

	/*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'user_info';
	// protected $primaryKey = 'id';
	// public $timestamps = false;
	protected $guarded = ['id'];
	protected $fillable = ['user_id', 'name', 'image', 'gender', 'age', 'length', 'weight', 'target_weight'];
	protected $hidden = ['user_id'];
	// protected $dates = [];

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function user() {
		return $this->belongsTo(BackpackUser::class);
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
	public function setLengthAttribute($length) {
		$this->attributes['length'] = $length / 100;
	}
	public function getLengthAttribute($length) {
		return $length * 100;
	}

	public function getProfileImageAttribute() {
		$gender = $this->gender;
		$html = '';
		if($this->image) :
			$html = '<img src="'.$this->image.'" class="profile-photo" alt="'.$this->name.'">';
		elseif($gender == 'male') :
			$html = '<img src="'.asset("images/account/male.jpg").'" class="profile-photo" alt="'.$this->name.'">';
		elseif($gender == 'female') :
			$html = '<img src="'.asset("images/account/female.jpg").'" class="profile-photo" alt="'.$this->name.'">';
		endif;
		return $html;
	}

	public function getImageAttribute( $image ) {
		if($image) {
			return '/uploads/'.$image;
		} else {
			return $this->getDefaultImageAttribute();
		}
	}

	public function getDefaultImageAttribute(  ) {
		$gender = $this->gender;
		if($gender == 'male') :
			return "/images/account/male.jpg";
		elseif($gender == 'female') :
			return "/images/account/female.jpg";
		endif;
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
		$destination_path = 'images/profiles/'.$this->id;

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
}
