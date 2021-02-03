@foreach($goals as $goal)
<option value="{{ $goal->id }}">{{ $goal->title }}</option>
@endforeach
