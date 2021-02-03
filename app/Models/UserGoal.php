<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class UserGoal extends Pivot {
	protected $table = 'goal_user';
	protected $keyType = 'string';

	public function totalWeeks(  ) {
		$start_date = Carbon::parse($this->start_date);
		$finish_date = Carbon::parse($this->finish_date);

		return $start_date->diffInWeeks($finish_date);
	}

	public function currentWeek(  ) {
		$start_date = Carbon::parse($this->start_date);
		$now = Carbon::now();
		return $start_date->diffInWeeks($now) + 1;
	}

	public function getPercentage(  ) {
		$total_weeks = $this->totalWeeks();
		$current_week = $this->currentWeek();
		return ($current_week / $total_weeks) * 100;
	}
}
