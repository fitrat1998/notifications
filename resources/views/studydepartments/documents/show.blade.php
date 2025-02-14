<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

        @font-face {
            font-family: "Times New Roman";
            src: url("{{ storage_path('times.ttf') }}") format("truetype");
        }


        body {
            font-family: "Times New Roman", serif;
            margin: 0;
            padding: 0;
        }


        @font-face {
            font-family: "DejaVu Sans";
            src: url("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/fonts/dejavu-sans/DejaVuSans.ttf") format("truetype");
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
            font-family: "DejaVu Sans", "Arial Unicode MS", sans-serif, "Times New Roman";
        }

        .header .span3 {
            text-align: right;
            flex-grow: 1;
            font-size: 16px;
            margin-left: 200px;
        }


        .header .span5 {
            text-align: left;
            flex-grow: 1;
            font-size: 16px;
            margin-right: 50px;
        }

        .header .span6 {
            text-align: center;
            flex-grow: 1;
            font-size: 16px;
            margin-left: 175px;
            font-family: "DejaVu Sans", "Arial Unicode MS", sans-serif, "Times New Roman";
        }

        .header .span7 {
            text-align: right;
            flex-grow: 1;
            font-size: 16px;
            margin-left: 100px;
        }

        .content {
            font-size: 16px;
            line-height: 1.5;
        }

        .header-rector {
            margin-bottom: 15px;
            margin-top: 45px;
            page-break-inside: avoid; /* Sahifa bo‘ylab bo‘linmasligi uchun */
        }



        table {
            width: 100% !important;
            font-size: 14px !important;
            margin-left: 5px !important;
            margin-right: 5px !important;

        }

        table td {
            width: 35px !important;
        }


    </style>
</head>
<body>

<div class="container">

    <div class="image-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('samsu_name.png'))) }}"
             alt="Logo">
    </div>


    <div class="header">
        <span class="title">BUYRUQ</span>
        <span class="note">Loyiha</span>
    </div>
    <div class="header">
        <span class="span1 "><span>{{ $documenttype->name  }}</span><br>{{ $userdocument->created_at->format('d-m-Y') }}</span>

        <span class="span2">&#8470;</span>
        <span class="span"> {{ $userdocument->id }}</span>

        <span class="span3">Samarqand sh.</span>
    </div>


    <div class="content">
        <p><strong>{!! $userdocument->comment  !!}</p>


        @php
            $lastUser = (object) $users->last(); // Massivni obyektga o‘girish
            $remainingUsers = $users->except($users->keys()->last());
        @endphp

        <div class="header d-flex justify-content-between align-items-center"
             style="margin-bottom: 15px; margin-top: 45px; page-break-inside: avoid;">
            <span class="span5">{{ $lastUser->position ?? 'Rektor' }}</span>

            <span class="span6 d-flex justify-content-center">
{{--                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qrCodePath)) }}" alt="QR Code"--}}
                {{--                         width="100">--}}
            </span>

            @if($lastUser && isset($lastUser->firstname) && isset($lastUser->lastname))
                {{ strtoupper(substr($lastUser->firstname, 0, 1)) }}.
                {{ isset($lastUser->middlename) ? strtoupper(substr($lastUser->middlename, 0, 1)) . '.' : '' }}
                {{ $lastUser->lastname }}
            @else
                <span></span>
            @endif

        </div>


        <p style="margin-top: 50px;"><strong>Loyiha yaratuvchisi:</strong><br> {{ $author->position }}
            - {{ strtoupper(substr($author->firstname, 0, 1)) }}
            . {{ strtoupper(substr($author->middlename, 0, 1)) }}. {{ $author->lastname }}</p>

        <p><strong>Tasdiqladi:</strong></p>

        {{--        {{ dd($remainingUsers) }}--}}

        @foreach($remainingUsers as $user)
            @if(isset($lastUser) && $lastUser->id != $user->id)
                <p>
                    {{ str_replace('?', "'", $user->position) }} (kelishildi) -
                    {{ strtoupper(substr(str_replace('?', "'", $user->firstname), 0, 1)) }}
                    .{{ strtoupper(substr(str_replace('?', "'", $user->middlename), 0, 1)) }}
                    .{{ str_replace('?', "'", $user->lastname) }}
                </p>


            @endif
        @endforeach


    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
