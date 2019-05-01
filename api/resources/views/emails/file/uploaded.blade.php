@component('mail::message')
# Introduction

Url to your file.

@component('mail::button', ['url' => $url])
$url
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
