<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Account Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color: #e9ecef;">
        <p>Silahkan klik kode dibawah ini untuk mengaktifkan akun anda.</p>
        <a href="{{ 'itsexpo.com/activate?token=' . $token . '&email=' . $email }}">
            {{ 'itsexpo.com/activate?token=' . $token . '&email=' . $email }}
        </a>
</body>
</html>
