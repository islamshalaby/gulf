<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=zahra-bold" />
    <link rel="stylesheet" href="/css/webview.css">
    <style>
        .editor-toolbar , .editor-preview-side , .CodeMirror , .editor-statusbar{
            display : none;
        } 
    </style>
    <?php if($lang == 'ar'){ ?>
        <style>
            body{
                direction : rtl;
            }
            .text-container .text{
                font-size : 20px;
            }    
        </style>
    <?php } ?>   
</head>
<body>
    <div class="container">
        <div class="text-container">
            <h1 class="title" >{{$title}}</h1>
        <p class="text" ><?=$text?></p>
        </div>
    </div>
    <script src="/admin/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/admin/plugins/editors/markdown/simplemde.min.js"></script>
    <script src="/admin/plugins/editors/markdown/custom-markdown.js"></script>


</body>
</html>