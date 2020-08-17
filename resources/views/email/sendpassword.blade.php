# Hello {{ $user->first_name }} {{ $user->last_name }},

<p>Your login Detail.</p>
<p> Username : {{$user->email}} </p>
<p> Password : {{$password}} </p>

@if (! empty($salutation))
<p>{{ $salutation }}</p>
@endif
