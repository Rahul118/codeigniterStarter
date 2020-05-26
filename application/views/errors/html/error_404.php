<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>404 Page Not Found</title>
    <style>
        html,
        body {
            height: 100%
        }

        body {
            display: grid;
            place-items: center;
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(234deg, #0540f9, #1c1d21);
            background-size: 400% 400%;
            -webkit-animation: animbackground 18s ease infinite;
            -moz-animation: animbackground 18s ease infinite;
            animation: animbackground 18s ease infinite;
            color: #fff
        }

        @-webkit-keyframes animbackground {
            0% {
                background-position: 82% 0%
            }

            50% {
                background-position: 19% 100%
            }

            100% {
                background-position: 82% 0%
            }
        }

        @-moz-keyframes animbackground {
            0% {
                background-position: 82% 0%
            }

            50% {
                background-position: 19% 100%
            }

            100% {
                background-position: 82% 0%
            }
        }

        @keyframes animbackground {
            0% {
                background-position: 82% 0%
            }

            50% {
                background-position: 19% 100%
            }

            100% {
                background-position: 82% 0%
            }
        }

        h1 {
            font-size: 50px;
            font-weight: 700;
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div>
        <h1><?php echo $heading; ?></h1>
        <p><?php echo $message; ?></p>
    </div>
</body>

</html>