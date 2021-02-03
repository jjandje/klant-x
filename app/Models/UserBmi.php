<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class UserBmi extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'user_bmis';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['user_info_id', 'bmi'];
    protected $hidden = ['user_info_id'];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function bmiDotsHtml(  ) {
		$bmi = $this->bmi;
		$html = '';
		switch($bmi) {
			case $bmi < 18.5:
				$html = '<span class="dot green"></span><span class="dot orange filled" title="Ondergewicht - Te licht, te weinig reserve bij ziekte."></span><span class="dot red"></span>';
				break;
			case $bmi >= 18.5 && $bmi <= 24.9:
				$html = '<span class="dot green filled" title="Normaal gewicht - U zit goed, proberen zo te houden."></span><span class="dot orange"></span><span class="dot red"></span>';
				break;
            case $bmi >= 25 && $bmi <= 29.9:
                $html = '<span class="dot green"></span><span class="dot orange filled" title="Licht overgewicht - Liefst afslanken tot gezond gewicht."></span><span class="dot red"></span>';
                break;
			case $bmi >= 30:
				$html = '<span class="dot green"></span><span class="dot orange"></span><span class="dot red filled" title="Overgewicht - Liefst afslanken tot gezond gewicht."></span>';
				break;
		}
		return $html;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
}
