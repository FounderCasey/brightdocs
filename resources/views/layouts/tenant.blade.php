<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="#" />


    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            color: #58687C;
        }

        .row {
            display: flex;
            flex-direction: row;
        }
        .column {
            display: flex;
            flex-direction: column;
        }
        .center {
            justify-content: center;
            align-items: center;
        }
        .between {
            justify-content: space-between;
            align-items: center;
        }
        .wrap {
            flex-wrap: wrap;
        }

        .ProseMirror {
            height: 90vh;
            overflow-y: auto;
        }

        .ProseMirror:focus {
            outline: none;
        }

        .pad-top {
            padding-top: 25px;
        }
    </style>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script src="/js/app.js"></script>
</body>
</html>
