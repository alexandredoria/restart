<?php
include 'classes/ocorrencia.class.php';
require_once 'classes/log.class.php';
session_start();
  if (isset($_GET['o'])){
      $IdOcorrencia = $_GET['o'];
      $LOG = new LOG;
      $editOcor = new Ocorrencia;
      $result = $editOcor->reabrirOcorrencia($IdOcorrencia);
      $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'REA_OCO', $result);
      unset($LOG);
      unset($editOcor);
    }
    header("Location: ../restart/verOcorrencia.php?o=$IdOcorrencia");
?>