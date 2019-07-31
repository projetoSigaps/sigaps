<!-- pdf.blade.php -->
<?php
$path = storage_path('app/_DOC/');
$foto = $militar->om_id.'/'.$militar->posto.'/'.$militar->ident_militar.'/'.$militar->datafile;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <style type="text/css">
  table.perfil {
    font-family: Arial, Helvetica, sans-serif;
    background-color: #EEEEEE;
    width: 100%;
    text-align: left;
    border-collapse: collapse;
  }
  table.perfil td, table.perfil th {
    border: 1px solid #FFFFFF;
    padding: 5px 4px;
  }
  table.perfil tbody td {
    font-size: 12px;
  }
  table.perfil thead {
    background: #CFCFCF;
    background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
    background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
    background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
    border-bottom: 3px solid #FFFFFF;
  }
  table.perfil thead th {
    font-size: 15px;
    font-weight: bold;
    color: #000000;
    text-align: left;
  }
  table.perfil tfoot td {
    font-size: 14px;
  }
</style>
</head>
<h4 style="text-align: center;font-family:Arial;">FICHA INDIVÍDUAL</h4>
<table class="perfil">
  <thead>
    <tr>
      <th>FOTO</th>
    </tr>
  </thead>
</table>
<img style="padding:5px;width:150px;" src="{{$path.$foto}}" id="foto" alt=".">
<table class="perfil">
  <thead>
    <tr>
      <th colspan="4">DADOS PESSOAIS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="font-weight: bold;">P/G:</td>
      <td>{{$militar->posto_nome}}
       <td style="font-weight: bold;">NOME DE GUERRA:</td>
       <td>{{$militar->nome_guerra}}</td>
     </tr>
     <tr>
       <td style="font-weight: bold;">NOME COMPLETO:</td>
       <td>{{$militar->nome}}</td>
       <td style="font-weight: bold;">IDENTIDADE:</td>
       <td>{{$militar->ident_militar}}</td>
     </tr>
     <tr>
       <td style="font-weight: bold;">CEP:</td>
       <td>{{$militar->cep}}</td>
       <td style="font-weight: bold;">ENDEREÇO:</td>
       <td>{{$militar->bairro." - ".$militar->endereco." - ".$militar->numero}}</td>
     </tr>
     <tr>
       <td style="font-weight: bold;">CIDADE:</td>
       <td>{{$militar->cidade}}</td>
       <td style="font-weight: bold;">ESTADO:</td>
       <td>{{$militar->estado}}</td>
     </tr>
     <tr>
       <td style="font-weight: bold;">CNH:</td>
       <td>{{$militar->cnh}}</td>
       <td style="font-weight: bold;">CATEGORIA E VENCIMENTO:</td>
       @if($militar->cnh_venc)
       <td>{{$militar->cnh_cat}} - {{date('d/m/Y', strtotime($militar->cnh_venc))}}</td>
       @else 
       <td>{{$militar->cnh_cat}}</td>
       @endif
     </tr>
     <tr>
       <td style="font-weight: bold;">CELULAR:</td>
       <td>{{$militar->celular}}</td>
       <td style="font-weight: bold;">STATUS:</td>
       <td>
        @if($militar->status == 1) ATIVADO
        @else DESATIVADO
        @endif
      </td>
    </tr>
    <tr>
     <td style="font-weight: bold;">ORGANIZAÇÃO MILITAR:</td>
     <td colspan="3">{{$militar->om_nome}}</td>
   </tr>
 </tbody>
</table>
<p style="padding-top:20px;"></p>
<table class="perfil">
  <thead>
    <tr>
      <th colspan="6">AUTOMOVÉIS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     <td style="font-weight: bold;">MARCA / MODELO</td>
     <td style="font-weight: bold;">ANO</td>
     <td style="font-weight: bold;">PLACA</td>
     <td style="font-weight: bold;">COR</td>
     <td style="font-weight: bold;">RENAVAM</td>
     <td style="font-weight: bold;">STATUS</td>
   </tr>
   @foreach($auto as $value)
   <tr>
    <td>{{$value->marca." \ ".$value->modelo}}</td>
    <td>{{$value->ano_auto}}</td>
    <td>{{$value->placa}}</td>
    <td>{{$value->cor}}</td>
    <td>{{$value->renavan}}</td>
    <td>
      @if($value->baixa == 1) ATIVADO
      @else DESATIVADO
      @endif
    </td>
  </tr>
  @endforeach
</tbody>
</table>
<hr>
<p style="font-size:11px;font-family:Arial;">SIGAPS - Sistema de Gerenciamento de Automóveis e Pessoas</p>
<p style="font-size:11px;font-family:Arial;text-align: right;">DATA E HORA: {{date("d/m/Y H:i")}}</p>
</body>
</html>

