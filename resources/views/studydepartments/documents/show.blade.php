<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        @font-face {
            font-family: "Times New Roman";
            src: url("{{ storage_path('times.ttf') }}") format("truetype");
        }


        body {
            font-family: "Times New Roman", serif;
            margin: 0 auto;
            padding: 0;
        }


        @font-face {
            font-family: "DejaVu Sans";
            src: url("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/fonts/dejavu-sans/DejaVuSans.ttf") format("truetype");
        }

        .container {
            width: 100%;
            margin: 0 auto;
            max-width: 1300px;
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

        .table-responsive {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    overflow-x: auto;
}

.table-responsive table {
    width: 100%;
    max-width: 900px; /* A4 formatga mos */
    border-collapse: collapse;
    table-layout: fixed;
    margin: 0 auto;
    page-break-inside: auto; /* Jadval o‘zidan o‘zi sahifalanadi */
}

.table-responsive th,
.table-responsive td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
    word-break: break-word;
}

@media print {
    .table-responsive table {
        page-break-inside: auto; /* Sahifa bo‘sh qolmasin */
    }

    .table-container {
        page-break-before: auto; /* Har safar yangi sahifa bo‘lmasligi uchun */
        page-break-after: auto;
    }
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

    <div class="a4-container">
    <div class="table-responsive">
        <div class="table-container">
            {!! $userdocument->comment !!}
        </div>
    </div>
</div>


    <div class="content">


        @php
            $lastUser = $users->last();
            $remainingUsers = $users->except($users->keys()->last());
        @endphp
        <div class="header d-flex justify-content-between align-items-center">
            <span class="span5">{{ $lastUser->position ?? 'Rektor' }}</span>


            <span class="span6 d-flex justify-content-center">
    {{--        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qrCodePath)) }}" alt="QR Code" width="100">--}}
        </span>

            <span class="span7">
            @if($lastUser)
                    {{ strtoupper(substr($lastUser->firstname, 0, 1)) }}.
                    {{ strtoupper(substr($lastUser->middlename, 0, 1)) }}. {{ $lastUser->lastname }}
                @endif
        </span>
        </div>


        <p><strong>Loyiha yaratuvchisi:</strong> {{ $author->position }}
            - {{ strtoupper(substr($author->firstname, 0, 1)) }}
            . {{ strtoupper(substr($author->middlename, 0, 1)) }}. {{ $author->lastname }}</p>

        <p><strong>Tasdiqladi:</strong></p>

        @foreach($remainingUsers as $user)
            <p>
                @if($lastUser->id != $user->id)
                    {{ strtoupper(substr($user->firstname, 0, 1)) }}
                    . {{ strtoupper(substr($user->middlename, 0, 1)) }}. {{ $user->lastname }}
                @endif
            </p>
        @endforeach


    </div>


</div>

<script>

</script>
</body>
</html>
