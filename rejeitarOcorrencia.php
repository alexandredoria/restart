<?php
include 'classes/ocorrencia.class.php';  
  if (isset($_GET['o'])){
      $IdOcorrencia = $_GET['o'];
      $editOcor = new Ocorrencia;
      $resultadoRejeitar = $editOcor->rejeitarOcorrencia($IdOcorrencia);
      
      unset($editOcor);
    }
    header("Location: ../restart/ocorrencias.php");
?>
