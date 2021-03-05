@component('mail::message')
# @lang('auth-logger::messages.hello')!  

{{ Lang::get('auth-logger::messages.content', ['app' => config('app.name')]) }}
  
<table>
    <tr>
        <td align="center">
            @if($deviceType == 'mobile')
            <svg height="120px" width="120px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            @elseif($deviceType == 'desktop')
            <svg height="120px" width="120px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            @elseif($deviceType == 'tablet')
            <svg height="120px" width="120px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            @endif
        </td>
        <td width="75%">
            <b>@lang('auth-logger::messages.account'):</b> {{ $account->email }}<br>
            <b>@lang('auth-logger::messages.time'):</b> {{ $time->toCookieString() }}<br>
            <b>@lang('auth-logger::messages.ip_address'):</b> {{ $ipAddress }}<br>
            <b>@lang('auth-logger::messages.browser'):</b> {{ $browser }} <small>{{ $browserVersion ?? '' }}</small><br>
            <b>@lang('auth-logger::messages.platform'):</b> {{ $platform }} <small>{{ $platformVersion ?? '' }}</small><br>
            @if($deviceName)
            <b>@lang('auth-logger::messages.device'):</b> {{ $deviceName }}
            @endif
        </td>
    </tr>
</table>  
<br>  
  
@lang('auth-logger::messages.ignore')  
  
@lang('auth-logger::messages.regards'),<br>{{ config('app.name') }}
@endcomponent