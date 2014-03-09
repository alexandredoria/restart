<?php
include 'classes/ocorrencia.class.php';
require_once 'classes/log.class.php';
session_start();
  if (isset($_GET['o'])){
      $IdOcorrencia = $_GET['o'];
      $editOcor = new Ocorrencia;
      $LOG = new LOG;
      $result = $editOcor->fecharOcorrencia($IdOcorrencia);
      $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'FEC_OCO', $result);
      unset($LOG);
      unset($editOcor);
    }
    header("Location: ../restart/verOcorrencia.php?o=$IdOcorrencia");
?>