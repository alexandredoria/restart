<?php


   require_once("funcoes.php");
   //date_default_timezone_set('America/Sao_Paulo'); 
   

   if ((isset($_POST["cod_membro"])) && ($_POST["cod_membro"]!='')){
 
	  $cod=$_POST["cod_membro"];
	  $dataatual=date(time());
	  $data=date('d/m/Y H:i:s',$dataatual-4*3600);
	  $limite= explode("-",$_POST["data_limite"]);
	  
	  
	  
	  $chave=conectar_banco();
	 if ($chave!==FALSE){
		$sql="SELECT Evento.Nome as E_nome, Membro.Nome as M_Nome, Hora, DataEvento, Tipo FROM Evento, Membro, Membro_has_Evento WHERE Evento.idEvento= Membro_has_Evento.Evento_idEvento AND Membro.idMembro=Membro_has_Evento.Membro_idMembro AND Membro.idMembro=".$cod." AND DataEvento <= ".mktime(00,00,00,$limite[1],$limite[2],$limite[0])." AND DataEvento >= ".time(). ";";
		$res=mysql_query($sql,$chave);
		
		if ($res===FALSE){
			echo"<h3 align='center'>Evento não encontrado!</h3><a href='listar_eventos.php'><input type='button' value='Voltar' /></a>
<hr />";
		}else{
			$tabela='';
			while($evento=mysql_fetch_assoc($res)){
					$tabela.="<tr> <td>".$evento["E_nome"]."</td><td>".$evento["Tipo"]."</td><td>".date('d/m/Y', $evento["DataEvento"])."</td><td>".date('H:i',$evento["Hora"])."</td></tr>";
					$nome_membro=$evento["M_Nome"];
			}
		}
	 }
	  $relatorio='
<html>
<head>
<style>
        *
        {
            margin:0;
            padding:0;
            font-family:Arial;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-size:10pt;
            margin:0;
            padding:0;
        }
         
        p
        {
            margin:0;
            padding:0;
        }
         
        #wrapper
        {
            width:180mm;
            margin:0 15mm;
        }
         
        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }
 
        table
        {
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            border-spacing:0;
            border-collapse: collapse; 
             
        }
         
        table td 
        {
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 2mm;
        }
		table th
        {
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 2mm;
			background:#eee;

        }
         
        table.heading
        {
            height:50mm;
        }
         
        h1.heading
        {
            font-size:14pt;
            color:#000;
            font-weight:normal;
        }
         
        h2.heading
        {
            font-size:9pt;
            color:#000;
            font-weight:normal;
        }
         
        hr
        {
            color:#ccc;
            background:#ccc;
        }
         
        #invoice_body
        {
            height: 149mm;
        }
         
        #invoice_body , #invoice_total
        {   
            width:100%;
        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
     
            border-spacing:0;
            border-collapse: collapse; 
             
            margin-top:5mm;
        }
         
        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding:2mm 0;
        }
         
        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            font-family:monospace;
            text-align:right;
            padding-right:3mm;
            font-size:10pt;
        }
         
        #footer
        {   
            width:180mm;
            margin:0 15mm;
            padding-bottom:3mm;
        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
             
            background:#eee;
             
            border-spacing:0;
            border-collapse: collapse; 
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
<hr>

        <h2 align="center">Paróquia Santa Lúcia</h2>

<p align="right">'.$data.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<hr>
<b><h2 align="center">Relatório de Eventos Personalizado</h2></b>
<hr>';

 if(!isset($nome_membro)){
	 $relatorio.='<h3 align="center"> O membro selecionado não possui eventos nesse período</h3>
	 <htmlpagefooter name="footer">
<hr />
<div id="footer"> 
    <table>
        <tr><td>Paróquia Santa Lúcia</td></tr>
    </table>
</div>
</htmlpagefooter>
<sethtmlpagefooter name="footer" value="on" />
</body>
</html>'; 
 }else{ 
    $relatorio.='
 <table align="center">
 <tr>
 <td>Membro: </td> <td>'.$nome_membro.'</td>
 </tr>
 </table>
 
  <br>
  <br> 
 <table align="center">
 <tr>
 <th>Nome do Evento </th> <th>Tipo</th> <th>Data</th> <th>Hora</th>
 </tr>
 '.$tabela.'
  </table>
  

<htmlpagefooter name="footer">
<hr />
<div id="footer"> 
    <table>
        <tr><td>Paróquia Santa Lúcia</td></tr>
    </table>
</div>
</htmlpagefooter>
<sethtmlpagefooter name="footer" value="on" />
</body>
</html>

';
	  
 }
  include('MPDF57/mpdf.php');
  $mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
 
$mpdf->SetDisplayMode('fullpage');
 
$mpdf->list_indent_first_level = 0; 
  $mpdf->WriteHTML($relatorio);
  $mpdf->Output();
  exit();
	
   }else{
	  $mostrarhtml="sim";
   }
   if ($mostrarhtml=='sim'){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paróquia Santa Lúcia</title>
<hr />
<b><h2 align="center">Gerar Relatório de Eventos Personalizado</h2></b>
<hr />
</head>


<body>
<form action="relatorio.php" method="post">

Selecionar Membro

<select name='cod_membro'>
<?php
require_once("funcoes.php"); 
	$chave=conectar_banco();
	 if ($chave!==FALSE){
		$sql="SELECT idMembro, Nome, Email FROM Membro WHERE 2=2";
		$res=mysql_query($sql,$chave);
		if ($res===FALSE){
			echo"<h3 align='center'>Membro não encontrado!</h3>";
		}else{
			while($var=mysql_fetch_assoc($res)){
				$membros[]=$var;
				}
			foreach($membros as $indice=>$linha){
				echo "<option value='".$linha["idMembro"]."'>".$linha["Nome"]."<option>";
			}
		}
	 }else{
		echo"<h3 align='center'>Membro não encontrado!</h3>";	
	 }
?>
</select><br /><br />
Do dia atual até: <br />
 <input type="date" name='data_limite'>
 <input type="submit" value="Gerar" />
 <hr />
 <a href="principal.php"><input type="button" value="Voltar" /></a>
 
</body>
</html>
<?php
   }
?>