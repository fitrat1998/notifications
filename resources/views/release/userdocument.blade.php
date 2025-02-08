<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>


        body {
            font-family: "DejaVu Sans", "Times New Roman"f;
            margin: 0;
            padding: 0;
        }

        @font-face {
            font-family: "DejaVu Sans";
            src: url("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/fonts/dejavu-sans/DejaVuSans.ttf");
        }

        .container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 15px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 0px;
            top: 0px;
        }

        .image-container img {
            max-width: 850px;
            height: auto;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 60px; /* Headerning balandligini belgilash */
        }

        .header .title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            font-weight: bold;

        }


        .header .note {
            position: absolute;
            right: 0;
            color: darkred;
            font-size: 16px;
        }


        .header .span1 {
            text-align: left;
            flex-grow: 1;
            font-size: 16px;
            margin-right: 50px;
        }

        .header .span2 {
            text-align: center;
            flex-grow: 1;
            font-size: 16px;
            margin-left: 175px;
        }

        .header .span3 {
            text-align: right;
            flex-grow: 1;
            font-size: 16px;
            margin-left: 200px;
        }

        .content {
            font-size: 16px;
            line-height: 1.5;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="image-container">
        <img src="{{ public_path('samsu_name.png') }}" alt="Logo">
    </div>

    <div class="header">
        <span class="title">{{ $documenttype->name }}</span>
{{--        <span class="note">Loyiha</span>--}}
    </div>
    <div class="header">
        <span class="span1">{{ $userdocument->created_at->format('d-m-Y') }}</span>
        <span class="span2">№ {{ $userdocument->id }}</span> <!-- "№-" emas, "№ " qoldiring -->
        <span class="span3">Samarqand sh.</span>
    </div>


    <div class="content">
        <p><strong>{!! $userdocument->comment  !!}</p>


        <p><strong>Hujjat yaratuvchisi:</strong> {{ $author->position, }}
            - {{ strtoupper(substr($author->firstname, 0, 1)) }}
            . {{ strtoupper(substr($author->middlename, 0, 1)) }}. {{ $author->lastname }}</p>

        @foreach($users as $user)
            <p><strong>Tasdiqladi:</strong> {{ strtoupper(substr($user->firstname, 0, 1)) }}
                . {{ strtoupper(substr($user->middlename, 0, 1)) }}. {{ $user->lastname }}</p>
        @endforeach



        <div class="d-flex justify-content-end">
                <img src="{{$qrCodePath}}" alt="QR Code" width="100">
            </div>


    </div>


</div>

</body>
</html>


{{-- <div class="container">--}}
{{--        <div class="content">--}}
{{--            <p>{!! $userdocument->comment !!}</p>--}}
{{--            <p><strong>Kim tomonidan yaratilgan:</strong>  {{ strtoupper(substr($author->firstname, 0, 1)) }}. {{ strtoupper(substr($author->middlename, 0, 1)) }}. {{ $author->lastname }}</p>--}}

{{--            @foreach($users as $user)--}}
{{--                <p><strong>Tasdiqladi:</strong> {{ strtoupper(substr($user->firstname, 0, 1)) }}. {{ strtoupper(substr($user->middlename, 0, 1)) }}. {{ $user->lastname }}</p>--}}
{{--            @endforeach--}}

{{--            <!-- Sana va QR kodni flexbox yordamida chap tomonda joylashtirish -->--}}

{{--                <p><strong>Yaratilgan sana:</strong> {{ $userdocument->created_at->format('Y-m-d') }}</p>--}}
{{--        </div>--}}

{{--            <div class="d-flex justify-content-end">--}}
{{--                <img src="{{$qrCodePath}}" alt="QR Code" width="100">--}}
{{--            </div>--}}
{{--    </div>--}}
