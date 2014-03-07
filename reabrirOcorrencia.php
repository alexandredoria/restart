<?php
include 'classes/ocorrencia.class.php';  
  if (isset($_GET['o'])){
      $IdOcorrencia = $_GET['o'];
      $editOcor = new Ocorrencia;
      $resultadoReabrir = $editOcor->reabrirOcorrencia($IdOcorrencia);
      
      unset($editOcor);
    }
    header("Location: ../restart/ocorrencias.php");
?>
