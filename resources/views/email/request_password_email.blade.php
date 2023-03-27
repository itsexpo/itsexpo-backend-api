<!DOCTYPE html>
<html>
  <head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <style>
      body {
        background: linear-gradient(to right bottom, #FED880, #DE686B);
        height: 100vh;
        margin: 0;
      }

      .card {
        width: 400px;
        height: 631px;
        margin: 0 auto 0;
        background-color: #fff;
        box-shadow: 0px 5px 10px 5px rgba(0, 0, 0, 0.15);
        text-align: left;
        border-radius: 10px;
        overflow: hidden;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
      }

      .header {
        background-image: url("https://res.cloudinary.com/dqpzaw0pm/image/upload/v1675348292/Asset%20ITS%20EXPO/header-email_ifztd1.png");
        background-size: cover;
        height: 80px;
      }

      .footer {
        background-image: url("https://res.cloudinary.com/dqpzaw0pm/image/upload/v1675348319/Asset%20ITS%20EXPO/footer-email_epe8gu.png");
        background-size: cover;
        height: 80px;
        position: relative;
      }

      .content {
        padding: 10px;
        /* position: relative; */
      }

      /* button align center  */
      .btn {
        display: block;
        margin: 0 auto;
        width: 335px;
        background-color: #8AB364;
        color: #fff;
        padding: 10px 10px;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        font-size: 16px;
        font-family: "Montserrat", sans-serif;
        font-weight: 600;
      }
      h2{
        font: 600 14px "Montserrat", sans-serif;
        color: #9AA2B1;
        text-align: center;
        font-style: normal;
      }
      h3{
        font: 400 18px "Montserrat", sans-serif;
        color: #092540;
        padding-left: 12px;
      }
      h4, h5, p {
        font: 400 16px "Montserrat", sans-serif;
        color: #092540;
        padding-left: 12px;
      }
      h6{
        font:400 12px "Montserrat", sans-serif;
        color: #9AA2B1;
      }
      hr{
        border: 0.00001px solid #D1D5DC;
        width: 335px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div class="card">
      <div class="header"></div>
      <div class="content">
        <h3><strong>Selamat Datang di ITS EXPO 2023!</strong></h3>
        <h5>Silahkan klik kode dibawah ini untuk mengganti password akun anda.</h5>
        <a href="{{ 'https://expo-its.com/forgot-password?token=' . $token  }}">Forgot Password</a>
        <!-- h6 align center -->
        <h6 align="center">Tolong jangan balas pesan ini. Email ini dikirim dari alamat email khusus pemberitahuan yang tidak dapat menerima email masuk.</h6>
        <!--Garis pembatas-->
        <hr>
    <!-- icon Tiktok, instagram, and youtube, align center -->
        <h6 align="center">
            <a href="https://vt.tiktok.com/ZS8yATae9/" style="text-decoration: none;">
            <img src="https://res.cloudinary.com/dqpzaw0pm/image/upload/v1675348720/Asset%20ITS%20EXPO/tiktok_jkm9tc.png" width="30" height="30" alt="Tiktok" style="margin-right: 24px;">
          </a>
          <a href="https://www.instagram.com/its_expo/" style="text-decoration: none;">
            <img src="https://res.cloudinary.com/dqpzaw0pm/image/upload/v1675348720/Asset%20ITS%20EXPO/Instagram_o0ek2q.png" width="30" height="30" alt="Instagram" style="margin-right: 24px;">
          </a>
          <a href="https://youtube.com/@ITSEXPO2021" style="text-decoration: none;">
            <img src="https://res.cloudinary.com/dqpzaw0pm/image/upload/v1675348720/Asset%20ITS%20EXPO/youtube_mety6r.png" width="30" height="30" alt="Youtube">
          </a>
        </h6>

        <h2>ITS EXPO 2023</h2>
    </div>
      <div class="footer"></div>
    </div>
  </body>
</html>