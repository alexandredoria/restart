<?php
  session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  }

  $pageTitle  = "Restart";
  
  include 'nucleo/cabecario.php';
  include 'classes/usuario.class.php';
  if ($_SESSION['tipo_usuario'] != 1) {
    $expUser  = new Usuario;
    $expUser->expirarUsuario($_SESSION['matricula']);           
    unset($expUser);
  }
?>
<body>

    <div id="wrapper">

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral.php");
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
                    <i class="fa fa-check fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">12</p>
                    <p class="announcement-text">Lista de afazeres</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Concluir tarefas
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
                    <i class="fa fa-tasks fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">3</p>
                    <p class="announcement-text">Erros encontrados</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Corrigir problemas
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
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading">2</p>
                    <p class="announcement-text">Novos Chamados!</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Atender Chamados
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
                <h3 class="panel-title"><i class="fa fa-clock-o"></i> Atividades recentes</h3>
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

               

   

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>

  </body>
</html>
