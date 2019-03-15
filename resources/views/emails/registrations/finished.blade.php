@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('Hello')
 {{$runner->firstname}}!
@endif
@endif

{{-- Intro Lines --}}
<p>Skvělé! Dokázal/a jsi to! Jsi v cíli se skvělým časem {{date('H:i:s', $runner->timems)}}. Moc ti děkujeme za tvou účast a těšíme se na tebe třeba opět příští ročník.</p>

{{-- Action Button --}}
@isset($runner->timems)
<?php
switch ($level) {
case 'success':
	$color = 'green';
	break;
case 'error':
	$color = 'red';
	break;
default:
	$color = 'blue';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ date('H:i:s', $runner->timems) }}
@endcomponent
@endisset


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
@isset($race)
    {{$race}}
@endisset
@empty($race)
    {{ config('app.name') }}
@endempty
@endif

{{-- Subcopy --}}
@isset($actionUrl)
@component('mail::subcopy')
<p>If you’re having trouble with the time, leave me a message.</p>
[{{ $actionUrl }}]({!! $actionUrl !!})
@endcomponent
@endisset
@endcomponent
