@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hello!
@endif
@endif

คุณได้รับอีเมล์ในการเปลี่ยนรหัสผ่าน

{{-- Action Button --}}
@isset($actionText)
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
{{ $actionText }}
@endcomponent
@endisset


ให้คุณ Reset Password เพื่อที่จะสามารถเข้าสู่ระบบได้


{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
ขอแสดงความนับถือ<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
คลิกที่ปุ่ม "{{ $actionText }}" หรือคลิกลิงค์ที่นี่เพื่อเปลี่ยนรหัสผ่าน: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
