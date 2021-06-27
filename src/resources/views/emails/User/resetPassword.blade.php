{{ $name }} 様
<br />
<br />

ご登録いただきありがとうございます。
<br />
<br />

下記のURLへ「30分以内」にアクセスいただき、パスワードの再登録を行ってください。
<br />
<br />

※有効期限は「{{ $expired_time }}分」になります。
<br />
<br />

<button>
    <a href="{{ $base_url . "/forgot-password/reset?" . $token }}">
        確認する
    </a>
</button>

<br />
<br />

URL
<br />
<a href="{{ $base_url . "/forgot-password/reset?" . $token }}">
    {{ $base_url . "/forgot-password/reset?" . $token }}
</a>
<br />
<br />

@include('emails._footer')
