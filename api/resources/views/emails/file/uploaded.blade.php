@component('mail::message')
# Introduction

Url to your file.

@component('mail::button', ['url' => config('app.url').$url])
    {{ config('app.url').$url }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
