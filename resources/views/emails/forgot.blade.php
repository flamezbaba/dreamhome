@extends('layouts/email')

@section('content')
    @php
        $r_url = env('DASHBOARD_URL') . '/reset-password/' . $user->reset_token;
    @endphp

    <tr>
        <td style="padding:30px;background-color:#eee;color:#000;line-height: 1.5;">
            <p> <span style="text-transform: capitalize;">Hello {{ $user->fullname ?? '' }}</span>,<br />
                Your Password Reset Link is <a href="{{ $r_url }}"><b
                        style="font-size: 18px">{{ $r_url }}</b></a></p>
        </td>
    </tr>
@endsection
