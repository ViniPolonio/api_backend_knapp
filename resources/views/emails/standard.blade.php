<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email</title>
</head>
<body>
    {!! $body !!}
</body>
</html>
