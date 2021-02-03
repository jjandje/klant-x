<h4 class="user-goals__title">{{ __('account.goals') }}</h4>
@foreach($user_goals as $key => $goal)
    <div class="row d-flex align-items-center justify-content-between mb-3">
        <div class="col">
            <p class="user-goals__variable"><a href="{{ route('profile.goals.show', ['slug' => $goal->slug]) }}">{{ $key + 1 }}. {{ $goal->title }}</a></p>
        </div>
        <div class="col-xl-6">
            @if($goal->pivot->active && !empty($goal->pivot->start_date) && !empty($goal->pivot->finish_date))
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $goal->pivot->getPercentage() }}%;" aria-valuenow="{{ $goal->pivot->getPercentage() }}" aria-valuemin="0" aria-valuemax="{{ $goal->pivot->totalWeeks() }}"></div>
                </div>
                <span style="display: inline-block;">Week {{ $goal->pivot->currentWeek() }} van {{ $goal->pivot->totalWeeks() }}</span>
            @elseif($goal->pivot->active && !empty($goal->pivot->start_date) && $goal->pivot->finished)
                <div class="button button--primary" id="restartGoal" data-uid="{{ backpack_user()->id }}" data-gid="{{ $goal->id }}">Opnieuw starten</div>
            @elseif($goal->pivot->active)
                <div class="button button--primary" id="startGoal" data-uid="{{ backpack_user()->id }}" data-gid="{{ $goal->id }}">Starten</div>
            @endif
        </div>
        <div class="col-xl-4 d-flex align-items-center justify-content-end">
            @if($goal->pivot->active && !empty($goal->pivot->start_date) && !empty($goal->pivot->finish_date))
                <div class="button" id="stopGoal" data-uid="{{ backpack_user()->id }}" data-gid="{{ $goal->id }}">Stop</div>
                <div class="button button--primary ml-3" id="restartGoal" data-uid="{{ backpack_user()->id }}" data-gid="{{ $goal->id }}">Opnieuw starten</div>
            @endif
        </div>
    </div>
@endforeach
