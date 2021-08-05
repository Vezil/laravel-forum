<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Email</title>
</head>

<body>
    <h2>Hello {{$emailData['name']}}!</h2>
    <p>Welcome in the laravel forum</p>
    <p>Please click the below link to verify your email and activate your account!</p>

    <a href="{{$appUrl}}/account/verify?code={{$emailData['verificationCode']}}">CLICK HERE</a>

    <p>Thanks, Admin</p>

</body>

</html>