<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Backpack\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class BackpackUser extends User
{
    use InheritsRelationsFromParentModel;
    use Notifiable;

    protected $table = 'users';


	public static function boot(  ) {
		parent::boot();

		static::deleting(function($user) {
			if($user->userBmi()->exists()) $user->userBmi()->delete();
			if($user->userInfo()->exists()) $user->userInfo()->delete();
			if($user->companies()->exists()) $user->companies()->detach();
			if($user->goals()->exists()) $user->goals()->detach();
			if($user->favoriteRecipes()->exists()) $user->favoriteRecipes()->detach();
			if($user->favoriteArticles()->exists()) $user->favoriteArticles()->detach();
			if($user->coaches()->exists()) $user->coaches()->detach();
			if($user->clients()->exists()) $user->clients()->detach();
			if($user->articles()->exists()) $user->articles()->dissociate();
			if($user->recipes()->exists()) $user->recipes()->dissociate();
			if($user->receivedMessages()->exists()) $user->receivedMessages()->dissociate();
			if($user->sentMessages()->exists()) $user->sentMessages()->dissociate();
		});
    }


    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	/**
	 * Get users active goals
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function activeGoals() {
		return $this->goals()->wherePivot('active', 1)->orderBy('goal_user.start_date', 'desc')->get();
	}

	/**
	 * Get Goals where user doesn't have a relation with yet
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function inactiveGoals() {
		$goals = Goal::whereNotIn('id', $this->goals->modelKeys())->get();
		$inactiveGoals = $this->goals()->wherePivot('active', 0)->get();
		if($inactiveGoals->count() > 0) {
			$goals = $goals->merge($inactiveGoals);
		}
		return $goals;
	}

	/**
	 * Get all sent messages where receiver_id = $id
	 * @param $id
	 *
	 * @return mixed
	 */
	public function SentMessagesTo( $id ) {
		return $this->sentMessages->where('recipient_id', (int)$id);
	}

	/**
	 * Get all received messages where sender_id = $id
	 * @param $id
	 *
	 * @return mixed
	 */
	public function ReceivedMessagesFrom( $id ) {
		return $this->receivedMessages->where('sender_id', (int)$id);
	}

	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	/**
	 * User companies relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function companies() {
		return $this->belongsToMany('App\Models\Company', 'company_user')->withTimestamps();
	}

	/**
	 * User info relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function userInfo() {
		return $this->hasOne(UserInfo::class);
	}

	/**
	 * User bmi relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
	 */
	public function userBmi() {
		return $this->hasOneThrough(UserBmi::class, UserInfo::class, 'user_id', 'user_info_id', 'id', 'id');
	}

	/**
	 * User -> Goal relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function goals() {
		return $this->belongsToMany(Goal::class, 'goal_user')
		            ->using(UserGoal::class)
					->withPivot([
						'active',
						'start_date',
						'finish_date',
					])
		            ->withTimestamps();
	}

	/**
	 * Users favorited recipes relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function favoriteRecipes() {
		return $this->belongsToMany(Recipe::class, 'recipe_user')->withTimestamps();
	}

	/**
	 * Users favorited articles relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function favoriteArticles() {
		return $this->belongsToMany(Article::class, 'article_user')->withTimestamps();
	}

	/**
	 * Author's articles relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function articles(  ) {
		return $this->hasMany(Article::class);
	}

	/**
	 * Author's recipes relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function recipes(  ) {
		return $this->hasMany(Recipe::class);
	}

	/**
	 * Client -> Coach relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function coaches(  ) {
		return $this->belongsToMany(BackpackUser::class, 'coach_user', 'user_id', 'coach_id')->withTimestamps();
	}

	/**
	 * Coach -> Client relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function clients(  ) {
		return $this->belongsToMany( BackpackUser::class, 'coach_user', 'coach_id', 'user_id')->withTimestamps();
	}

	/**
	 * All received messages by user relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function receivedMessages(  ) {
		return $this->hasMany(UserMessage::class, 'recipient_id', 'id');
	}

	/**
	 * All send messages by user relation
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sentMessages(  ) {
		return $this->hasMany(UserMessage::class, 'sender_id', 'id');
	}



	/*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
	public function scopeClientsGroupedByCompany(  ) {
		return $this->clients->groupBy('company.name');
	}

	/*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
	/**
	 * Get users company
	 * @return mixed
	 */
	public function getCompanyAttribute() {
		return $this->companies()->first();
	}

	/**
	 * Get users profile image from userinfo
	 * @return |null
	 */
	public function getProfileImageAttribute(  ) {
		return $this->userInfo->profileImage ?? null;
	}

	public function getDefaultImageAttribute(  ) {
		return $this->userInfo->defaultImage;
	}

	/**
	 * Get users image from userinfo
	 * @return string
	 */
	public function getImageAttribute() {
		return $this->userInfo->image ?? '#';
	}

	/**
	 * Get users name from userinfo
	 * @return string
	 */
	public function getNameAttribute(  ) {
		return $this->userInfo->name ?? '';
	}

	/**
	 * Get users about from userinfo
	 * @return string
	 */
	public function getAboutAttribute(  ) {
		return $this->userInfo->about ?? '';
	}

	/**
	 * Get coach names
	 * @return string
	 */
	public function getCoachNames(  ) {
		return implode(', ', $this->coaches->pluck('name')->toArray());
	}

	/*
    |--------------------------------------------------------------------------
    | SETTERS
    |--------------------------------------------------------------------------
    */
	public function setNameAttribute($value)
	{
		$user_info = $this->userInfo;
		if(empty($user_info)) return;

		$user_info->name = $value;
		$this->userInfo()->save($user_info);
	}

}
