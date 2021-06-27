{{ $name }} 様
<br />
<br />

ご登録いただきありがとうございます。
<br />
<br />

下記のURLへ「30分以内」にアクセスいただき、本登録を行ってください。
<br />
<br />

※有効期限は「{{ $expired_time }}分」になります。
<br />
<br />

<button>
    <a href="{{ $verificationUrl }}">確認する</a>
</button>

<br />
<br />

URL
<br />
<a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
<br />
<br />


@include('emails._footer')
