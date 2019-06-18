<?php

/* Configurações para Gerar QR */
include app_path().'/Libraries/phpqrcode/qrlib.php';
$rand = strtoupper( substr( md5(rand()), 0, 4));
$qrTempDir = '/tmp';
$filePath = $qrTempDir.'/'.uniqid();
QRcode::png("http://192.168.1.33/servicopolicia/controllers/RegEntradaAuto.php?token=".$rand."-".$veiculo->id, $filePath,QR_ECLEVEL_Q,3,1);
$qrImage = file_get_contents($filePath);
unlink($filePath);


?>

<html>
<head>
	<style type="text/css">table td{overflow: auto;}</style>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
	<table style="min-width:330px;TABLE-LAYOUT: fixed;position:static;font-size:11px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
		<tr>
			<td style="font-size: 18px;font-weight: bold;border-bottom: 1px solid black;padding-top:15px;padding-bottom: 15px;"><center>{{$veiculo->om_nome}}</center></td>
		</tr>
		<tr>
			<td style="font-size: 40px;font-weight: bold;"><center>Nº {{$veiculo->id}}</center></td>
		</tr>
	</table>
	<table style="min-width:196px;height:226px;TABLE-LAYOUT: fixed;position:static;font-size:12px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;">
		<tbody>
			<tr>
				<td>
					<p style="width:120px;font-size: 160px;">{{$veiculo->letra}}</p>
				</td>

				<td style="padding:26px;border:3px solid black;"><img src="data:image/png;base64,{{base64_encode($qrImage)}}"></td>
			</tr>
			<tr style="border-size:2px;border-style:solid;border-color:black;width: 100%;height:10%;">
				<td colspan="3" style="border-top:1px solid black;padding-top: 8px;padding-bottom: 8px;">

					<p style='text-transform: uppercase;font-size:16px;'><b>{{$veiculo->posto_nome." ".$veiculo->nome_guerra}}</b></p>
					<p style='text-transform: uppercase;font-size:15px;'><b>{{$veiculo->marca."/".$veiculo->modelo}}</b></p>
					<p style='text-transform: uppercase;font-size:15px;'><b>{{$veiculo->placa}}</b></p>
				</td>
			</tr>
		</tbody>
	</table>
	<table style="height:420px;width:335;font-size:12px;font-family:sans-serif;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;margin-left: 345px;margin-top: -420px;">
		<tr>
			<td><center><b>NORMAS DE USO</b></center></td>
		</tr>
		<tr>
			<td><span style="color:red;">1.VELOCIDADE:</span><br/>
				<strong>A Velocidade máxima dentro do complexo do CMO com veiculo automotor é de <u>30KM/H</u></strong>
			</td>
		</tr>
		<tr>
			<td><span>2.PERDA/ROUBO:<br/>
				<strong>Caso de perda ou roubo deste, avisar imediatamente o Serviço de Policia do CMO</strong>
			</span>
		</td>
	</tr>
	<tr>
		<td><span>3.USO DO PORTA ESTACIONAMENTO:<br/>
			<strong>Ao passarem pela Guarda do FORTE do CMO os veículos deverão obrigatoriamente estar com o Porta Estacionamento em local visível (sobre o retrovisor interno), permanecendo neste local durante toda permanência do veículo no complexo. Possibilitando a leitura de todos os dados nele contidos.</strong>
		</span>
	</td>
</tr>
<tr>
	<td  style="padding-bottom: 60px;">4.DEFINIÇÃO:<br/>
		<strong>O porta estacionamento define uma autorização de caráter pessoal e intransferível somente permitindo o livre acesso de veículo pelo condutor credenciado.
		</strong>
	</td>
</tr>
<tr>
	<td style="border-top:1px solid black;"><center>Chefe do Serviço de Policia</center></td>
</tr>
</table>
</body>
</html>