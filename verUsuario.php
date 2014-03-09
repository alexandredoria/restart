
<?php
  include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
  if (isset($_GET['m'])){$matricula = $_GET['m'];}
  $usuario = new Usuario;
  $nome  = $usuario->obterDados('nome', $matricula);
  $sobrenome  = $usuario->obterDados('sobrenome', $matricula);
  $situacao  = $usuario->obterDados('situacao', $matricula);
  if ($situacao == 1){
    $situacao = "Usuário ativo";
  } else {
    $situacao = "Usuário desativado";
  }
$pageTitle  = $nome." ".$sobrenome;
  include 'nucleo/cabecario.php';
  include 'nucleo/barraLateral.php';
  if ($usuario->obterDados('tipo_usuario', $matricula) == 1){
    $tipo = "Coordenador";
  } else if ($usuario->obterDados('tipo_usuario', $matricula) == 2){
    $tipo = "Bolsista";
  } else if ($usuario->obterDados('tipo_usuario', $matricula) == 3){
    $tipo = "Professor";
  }
      echo "
      <div id='page-wrapper'>
      <div class='row'>
        <div class='col-lg-12'>
          <h1> ".$nome." ".$sobrenome."</h1>
          <ol class='breadcrumb'>
            <li><a href='usuarios.php'><i class='glyphicon glyphicon-user'></i> Usuários</a></li>
            <li class='active'><i class='glyphicon glyphicon-search'></i> ".$nome." ".$sobrenome."</li>
          </ol>
        </div>
      </div><!-- /.row -->
      <div class='row'>
        <div class='col-lg-12'>
        </div>
      </div><!-- /.row -->
      <br>
      <div class='row'>
          <div class='col-lg-4'>
            <div class='panel panel-primary'>
              <div class='panel-heading'>
                <h3 class='panel-title'><i class='glyphicon glyphicon-time'></i> Atividades recentes</h3>
              </div>
              <div class='panel-body'>
                <div class='list-group'>
                  <a href='#' class='list-group-item'>
                    <span class='badge'>4 minutos atrás</span>
                    <i class='fa fa-comment'></i> Fez uma ocorrência no laboratório 06
                  </a>
                  <a href='#' class='list-group-item'>
                    <span class='badge'>1 hora atrás</span>
                    <i class='glyphicon glyphicon-user'></i> Um novo usuário foi adicionado
                  </a>
                  <a href='#' class='list-group-item'>
                    <span class='badge'>2 horas atrás</span>
                    <i class='fa fa-check'></i> Tarefa concluída: 'Formatar computadores do Laboratório 3'
                  </a>
                  <a href='#' class='list-group-item'>
                    <span class='badge'>2 dias atrás</span>
                    <i class='fa fa-check'></i> Tarefa Concluída: 'Configurar rede interna'
                  </a>
                </div>
                <div class='text-right'>
                  <a href='#'>Ver Todas Atividades <i class='fa fa-arrow-circle-right'></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class='col-lg-4'>
            <div class='media'>
            <a class='pull-left'>
              <img class='media-object' style='width: 50px; height: 50px;' src='img/".$usuario->obterDados('avatar', $matricula)."' alt='".$nome." ".$sobrenome."'>
            </a>
            <div class='media-body'>
              <h4 class='media-heading'>".$tipo."</h4>
              Matrícula ".$matricula."
            </div>
            <br>
            <div class='form-group'>
              <label>".$situacao."</label>
            </div>
            <div class='form-group'>
              <i class='glyphicon glyphicon-envelope'></i> ".$usuario->obterDados('email', $matricula)."
            </div>
             <div class='form-group'>
              <i class='glyphicon glyphicon-phone'></i> "; if ($tipo != 'Coordenador') { echo truncate($usuario->obterDados('telefone_celular', $matricula), 2, 12);} else {echo $usuario->obterDados('telefone_celular', $matricula);} echo "
            </div>
            <div class='form-group'>
              <i class='glyphicon glyphicon-earphone'></i> "; if ($tipo != 'Coordenador') { echo truncate($usuario->obterDados('telefone_celular', $matricula), 2, 12);} else {echo $usuario->obterDados('telefone_celular', $matricula);} echo "
            </div>
          </div>
          </div>
          <div class='col-lg-4'>
          </div>
       </div><!-- /.row -->
    </div><!-- /#page-wrapper -->";
?>
  </div><!-- /#wrapper -->
</body>
</html>