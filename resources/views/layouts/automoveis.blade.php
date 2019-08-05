<?php

if ($automovel->posto == "34") {
    $foto = $automovel->datafile;
} else {
    $foto = $automovel->om_id . '/' . $automovel->posto . '/' . $automovel->ident_militar . '/' . $automovel->datafile; //Pega o caminho da foto 
}

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
                    <img onerror="this.onerror=null;this.src='http://sigaps.cmo.eb.mil.br/images/unknown.jpg';" class="photo" src="{{Storage::disk('_DOC')->url(base64_encode($foto))}}" id="foto" alt="Foto">
                    <img class="status" style='margin-top:5px;' src="{{asset('images/'.$status)}}">
                </figure>
            </div>
            <div class="col-sm-7 info">
                <p class="well well-sm">{{$automovel->posto_nome}}</p>
                <p class="well well-sm">{{$automovel->nome_guerra}}</p>
                <p class="well well-sm">{{$automovel->om_nome}}</p>
                <p class="well well-sm text-success text-center">{{date("H:i")}}</p>
            </div>
            <div class="col-sm-7 info">
                <p class="well well-sm text-danger text-center">{{$automovel->marca}} - {{$automovel->modelo}}</p>
                <p class="well well-sm text-danger text-center">{{$automovel->placa}} • {{$automovel->cor}}</p>
            </div>
        </div>
    </div>
</body>

</html>