@component('mail::message')
# @lang('auth-logger::messages.hello')!  
  
{{ Lang::get('auth-logger::messages.content', ['app' => config('app.name')]) }}
  
> **@lang('auth-logger::messages.account'):** {{ $account->email }}<br>
> **@lang('auth-logger::messages.time'):** {{ $time->toCookieString() }}<br>
> **@lang('auth-logger::messages.ip_address'):** {{ $ipAddress }}<br>
> **@lang('auth-logger::messages.browser'):** {{ $browser }} ({{ $browserVersion }})<br>
> **@lang('auth-logger::messages.platform'):** {{ $platform }} ({{ $platformVersion }})  
  
@lang('auth-logger::messages.ignore')  
  
@lang('auth-logger::messages.regards'),<br>{{ config('app.name') }}
@endcomponent
