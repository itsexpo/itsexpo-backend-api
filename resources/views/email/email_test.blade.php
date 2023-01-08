<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Email Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color: #e9ecef;">
        <p> 
            Halo, {{ $name }}!
            Terima kasih telah mendaftarkan akun schematics 2023, berikut adalah data user milik anda
        </p>
        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $email }}</td>
            </tr>
            <tr>
                <td>Nomor Telpon</td>
                <td>: {{ $no_telp }}</td>
            </tr>
        </table>
</body>
</html>
