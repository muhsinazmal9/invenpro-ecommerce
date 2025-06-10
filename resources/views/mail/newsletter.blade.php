<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsletter->subject }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background: #f7f8fa;
        }

        .main-container {
            padding: 30px;
            margin: 0 auto;
            background: #fff;
            overflow: hidden;
        }

        footer {
            margin: 0 auto;
            padding-top: 30px;
        }

        footer .container {

            padding: 20px;
            background: #fff;
            margin-top: 10px;
        }

        footer .container .business-info {
            display: flex;
            justify-content: center
        }

        footer .footer-logo {
            text-align: center;
            max-width: 35px;
            display: inline;
        }

        footer .footer-details {
            display: flex;
            margin-top: 30px;
            text-align: center;
            flex-direction: column;

        }

        footer .footer-details a {
            display: inline;
            color: #6e6b6b;


        }
    </style>
</head>

<body>

    <div class="main-container">
        {!! $newsletter->body !!}
    </div>
    <footer>
        <div class="container">
            <div class="business-info">
                <div class="footer-logo">
                    <img style="width: 100%" src="{{ asset(getSetting('secondary_logo')) }}" alt="">
                </div>
                <div>
                    <p><a target="_blank" href="{{ getSetting('frontend_url') }}">{{ getSetting('site_title') }}</a></p>
                </div>
            </div>
            <div class="footer-details">
                <p>
                    you are receiving this email because you have subscribed to our newsletter. If you don't want to
                    receive emails from us, you can <a
                        href="{{ route('guest.unsubscribe',$subscriber->token) }}">unsubscribe</a> or by
                    sending an email to <a href="mailto:{{ getSetting('email') }}">{{ getSetting('email') }}</a>
                </p>
            </div>

        </div>
    </footer>
</body>

</html>
