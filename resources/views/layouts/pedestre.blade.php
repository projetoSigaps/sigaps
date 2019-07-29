<?php

$foto = $militar->om_id . '/' . $militar->posto . '/' . $militar->ident_militar . '/' . $militar->datafile; //Pega o caminho da foto 

?>
<html>

<head>
    <meta charset="utf8">
    <style type="text/css">
        .well {
            background-color: #d8d8d8 !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-sm-12">
            <div class="col-sm-5 thumb text-center">
                <figure>
                    <img class="photo" onerror='this.src="/sigaps/assets/img/unknown.jpg"' src="{{Storage::disk('_DOC')->url(base64_encode($foto))}}" id="foto" alt="Foto">
                    <img class="status" style='margin-top:5px;' src="{{asset('images/'.$status)}}">
                </figure>
            </div>
            <div class="col-sm-7 info">
                <p class="well well-sm">{{$militar->posto_nome}}</p>
                <p class="well well-sm">{{$militar->nome_guerra}}</p>
                <p class="well well-sm">{{$militar->om_nome}}</p>
            </div>
            <div class="col-sm-7 horario">
                <p class="well well-sm text-danger text-center">
                    {{date("H:i")}}
                </p>
            </div>
        </div>
    </div>
    </div>
</body>

</html>