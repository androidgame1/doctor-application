<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <style>
        body{
            padding:0px;
            margin:0px;
            font-family:sans-serif
        }
        .main{
            position: fixed;
            width:100%;
            height:100%;
            left:0px;
            right:0px;
            top:0px;
            bottom:0px;
            background:#4F5467;
        }
        .section-mail{
            position:fixed;
            width:500px;
            height:fit-content;
            margin:auto;
            left:0px;
            right:0px;
            top:0px;
            bottom:0px;
            padding:20px;
            background:white;
            border-radius:2px;

        }
        .header-mail{
            padding:10px;
        }
        .header-mail img{
            width:100%;
        }
        .footer-mail{
            padding:10px;
        }
        .link-mail{
            text-decoration:none !important;
            color:#4F5467 !important;
            transition:0.5s;
        }
        .link-mail:hover{
            text-decoration:none !important;
            color:#4F54678a !important;
        }
        .text-center{
            text-align:center !important;
        }
        .text-left{
            text-align:left !important;
        }
        .text-right{
            text-align:right !important;
        }
        .text-success{
            color:#4caf50
        }
        .text-danger{
            color:#f44336
        }
        .text-warning{
            color:#ff9800
        }
        .text-gray{
            color:#9e9e9e
        }
        .display-none{
            display:none !important;
        }
        .display-blick{
            display:block !important;
        }
        .display-inline-block{
            display:inline-block !important;
        }
        .btn-reset-password{
            padding: 20px 50px;
            background: #4F5467;
            border-radius: 20px;
            color: white !important;
            text-decoration: none !important;
            margin: auto;
            display: block;
            width: fit-content;
        }
        .btn-reset-password:hover{
            background: #4F5467b5;
        }
    </style>
</head>
<body>
    <header>
        
    </header>
    <main class="main">
        <section class="section-mail">
            @include('mail.HeaderMail')
            <hr>
            <div class="main-mail">
                <div><p class="text-center text-success">You are receiving this email because we have received a password reset request for your account</p></div>
                <div><p class="text-center text-gray">This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required, Regards</p></div>
                <div><a style="color:white" href="{{route('reset.password.get',['token'=>$data['token'],'email'=>$data['email']])}}" target="_blank" class="btn-reset-password">Reset password</a></div>
            </div>
            <hr>
            @include('mail.FooterMail')
            
        </section>
    </main>
    <footer>

    </footer>
</body>
</html>