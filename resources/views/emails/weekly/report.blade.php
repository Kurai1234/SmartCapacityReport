@component('mail::message')
# Good Day {{$username}}

Your Weekly Report is available for download.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
