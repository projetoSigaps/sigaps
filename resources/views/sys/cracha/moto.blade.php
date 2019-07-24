<?php

/* Configurações para Gerar QR */
include app_path() . '/Libraries/phpqrcode/qrlib.php';
$rand = strtoupper(substr(md5(rand()), 0, 4));
$qrTempDir = '/tmp';
$filePath = $qrTempDir . '/' . uniqid();
QRcode::png("http://192.168.1.33/servicopolicia/controllers/RegEntradaAuto.php?token=" . $rand . "-" . $veiculo->id, $filePath, QR_ECLEVEL_Q, 3, 1);
$qrImage = file_get_contents($filePath);
unlink($filePath);

?>

<html>
<head>
    <style type="text/css">
        table td {
            overflow: auto;
        }
    </style>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <table style="min-width:211px;TABLE-LAYOUT: fixed;position:static;font-size:10px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
        <tr>
            <td><img style="width:29px;" src="{{asset('images/brasao.gif')}}"></td>
            <td style="text-align:center;width:116px;">
                <p>Exército Brasileiro</p>
                <p>Comando Militar do Oeste</p>
            </td>
            <td><img style="width:35px;" src="{{asset('images/logo.jpg')}}"></td>
        </tr>
    </table>
    <table style="min-width:207px;height:226px;TABLE-LAYOUT: fixed;position:static;font-size:10px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
        <tbody>
            <tr>
                <td colspan="3" style="border-bottom:1px solid black;font-size: 24px;font-weight: bold;">
                    <center>Nº {{$veiculo->id}}</center>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="width:90px;font-size: 120px;">{{$veiculo->letra}}</p>
                </td>
                <td style="border-left:1px solid black;width: 108px;"><img style='width: 108px;' src="data:image/png;base64,{{base64_encode($qrImage)}}"></td>
            </tr>

            <tr style="border-size:2px;border-style:solid;border-color:black;width: 100%;height:10%;">
                <td colspan="3" style="border-top:1px solid black;word-break:">
                    <center>
                        {{$veiculo->posto_nome}} {{$veiculo->nome_guerra}} / {{$veiculo->om_nome}}<br />
                        <span style="font-size: 20px;font-weight: bold;">{{$veiculo->placa}}</span>
                    </center>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="text-align:justify;height:287px;width:211px;font-size:10px;font-size:8px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;margin-left: 214px;margin-top: -287px;">
        <tr>
            <td>
                <center><b>NORMAS DE USO</b></center>
            </td>
        </tr>
        <tr>
            <td><span>1.VELOCIDADE MÁX NO COMPLEXO DO CMO COM VEICULO: <strong style="color:red;">30KM</strong></span></td>
        </tr>
        <tr>
            <td><span>2.ATUALIZAÇÃO DOS DADOS:<br /><strong>O Militar deverá manter seus dados e os do veículo atualizados juntos ao Serviço de Polícia do CMO</strong></span></td>
        </tr>
        <tr>
            <td><span>3.DEVOLUÇÃO:<br /><strong>É obrigatório a devolução deste crachá em casos de tranferência do militar, encerramento de <br />tempo de serviço ou qualquer outro motivo que afaste o militar do CMO</strong></span></td>
        </tr>
        <tr>
            <td><span>4.PERDA/ROUBO:<br /><strong>Caso de perda ou roubo deste, avisar imediatamente o Serviço de Policia do CMO</strong></span></td>
        </tr>
        <tr>
            <td style="padding-bottom:40px;"><span>5.OBSERVAÇÃO:<br /><strong>O Descumprimento das presentes normas determina a suspensão ou cassação desta autorização e o recolhimento deste crachá.</strong></span></td>
        </tr>
        <tr>
            <td style="border-top:1px solid black;">
                <center>Chefe do Serviço Polícia</center>
            </td>
        </tr>
    </table>
</body>
</html>