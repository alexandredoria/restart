<?php
  include 'classes/ocorrencia.class.php';  
  session_start();
  if (isset($_GET['o'])){
      $IdOcorrencia = $_GET['o'];
      $editOcor = new Ocorrencia;
      $resultadoAssumir = $editOcor->assumirOcorrencia($IdOcorrencia, $_SESSION['matricula']);
      
      unset($editOcor);
      
    }
    header("Location: ../restart/ocorrencias.php");
?>
