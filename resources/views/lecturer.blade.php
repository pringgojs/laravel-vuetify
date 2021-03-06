<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Manajemen E-Tugas mahasiswa Politeknik Pertanian Negeri Pangkajene Kepulauan">
        <meta name="keywords" content="polipangkep,etugas polipangkep, e-tugas, manajemen e-tugas polipangkep">
        <meta name="author" content="Pringgo Juni Saputro | odyinggo@gmail.com | PENS">
        <title>Lecturer</title>

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/app.css')}}" />
        <style>
            a:hover{
                text-decoration: none        
            }
        </style>
    </head>
    <body>
        <div id="app">
            <layout></layout>
        </div>
    </body>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
    $( document ).ready(function() {
        $('#title-name').html('{{session("name")}}');
    });
    </script>
</html>
