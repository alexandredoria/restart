<?php
    include 'classes/usuario.class.php';
    include 'classes/ocorrencia.class.php';
    $pageTitle  = "Restart";
    include 'nucleo/cabecario.php';
    include("nucleo/barraLateral.php");
    if ($_SESSION['tipo_usuario'] != 1) {
      $expUser  = new Usuario;
      $expUser->expirarUsuario($_SESSION['matricula']);
      unset($expUser);
  }
  $ref = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : false ;
  if ($ref) {
    $ref = ($ref == "http://localhost/restart/") ? 1 : false ;
    if ($ref) {
      include 'classes/log.class.php';
      $LOG = new LOG;
      $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'LOGIN', 1);
      unset($LOG);
    }
  }
  unset($ref);
  $listaOcorrencia    = new Ocorrencia;
?>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Painel <small>Visão geral de Estatísticas</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Painel</li>
            </ol>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-4">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="glyphicon glyphicon-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">
                    <?php
                      $fechadas    = $listaOcorrencia->notificarOcorrencias(3, $_SESSION['matricula'], $_SESSION['tipo_usuario']);
                      if (is_array($fechadas)) {
                        foreach ($fechadas as $row) {
                          echo $row['count'];
                        }
                      }
                    ?>
                    </p>
                    <p class="announcement-text">Ocorrências fechadas</p>
                  </div>
                </div>
              </div>
              <a href="ocorrencias.php?f=3">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Ver todas
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="glyphicon glyphicon-tasks fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">
                    <?php
                      $incompletas     = $listaOcorrencia->notificarOcorrencias(4, $_SESSION['matricula'], $_SESSION['tipo_usuario']);
                      if (is_array($incompletas)) {
                        foreach ($incompletas as $row) {
                          echo $row['count'];
                        }
                      }
                    ?>
                    </p>
                    <p class="announcement-text">Erros encontrados<br></p><br>
                  </div>
                </div>
              </div>
              <a href="ocorrencias.php?f=4">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      <?php if ($_SESSION['tipo_usuario'] != 2) {echo "Ver todos";} else echo "Corrigir problemas";?>
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="glyphicon glyphicon-comment fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">
                    <?php
                      $abertas     = $listaOcorrencia->notificarOcorrencias(1, $_SESSION['matricula'], $_SESSION['tipo_usuario']);
                        foreach ($abertas as $row) {
                          echo $row['count'];
                        }
                    ?>
                    </p>
                    <p class="announcement-text"><?php if ($_SESSION['tipo_usuario'] != 2) {echo "Chamados abertos";} else echo "Novos chamados!";?></p>
                  </div>
                </div>
              </div>
              <a href="ocorrencias.php?f=1">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      <?php if ($_SESSION['tipo_usuario'] != 2) {echo "Ver todos";} else echo "Assumir chamados";?>
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Estatísticas de Atividades: 01 de outubro de 2013 - 31 de outubro de 2013</h3>
              </div>
              <div class="panel-body">
                <div id="morris-chart-area"></div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Atividades: 01 de outubro de 2013 - 31 de outubro de 2013</h3>
              </div>
              <div class="panel-body">
                <div id="morris-chart-donut"></div>
                <div class="text-right">
                  <a href="#">Ver Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-time"></i> Atividades recentes</h3>
              </div>
              <div class="panel-body">
                <div class="list-group">
                  <a href="#" class="list-group-item">
                    <span class="badge">agora mesmo</span>
                    <i class="fa fa-calendar"></i> Calendário Atualizado
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="badge">4 minutos atrás</span>
                    <i class="fa fa-comment"></i> Comentou em um post
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="badge">1 hora atrás</span>
                    <i class="glyphicon glyphicon-user"></i> Um novo usuário foi adicionado
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="badge">2 horas atrás</span>
                    <i class="fa fa-check"></i> Tarefa concluída: "Formatar computadores do Laboratório 3"
                  </a>
                  <a href="#" class="list-group-item">
                    <span class="badge">2 dias atrás</span>
                    <i class="fa fa-check"></i> Tarefa Concluída: "Configurar rede interna"
                  </a>
                </div>
                <div class="text-right">
                  <a href="#">Ver Todas Atividades <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
       </div><!-- /.row -->
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <?php
      unset($listaOcorrencia);
    ?>
    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
  </body>
</html>