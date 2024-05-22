@extends('layouts/email')

@section('content')

    <p dir="ltr"
        style="margin: 10px 0; padding: 0; mso-line-height-rule: exactly; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; color: #202020; font-family: Helvetica; font-size: 16px; text-align: left; line-height: 1.656; margin-top: 0pt; margin-bottom: 0pt; text-transform: capitalize;">
        {!! $data !!}
    </p>
@endsection
