<?php
  session_start();
  $sessao = new Usuario;
  $sessao->carregarSessao($_SESSION['matricula']);
  include 'funcoes.php';
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Marca e alterdação agrupados para uma melhor vizualização mobile -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Alternar navegação</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="painel.php">Restart </a>
        </div>
        <!-- Coletar os links de navegação, formulários e outros conteúdos para alternar -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
             <li <?php if ($pageTitle == "Restart") echo "class='active'"; ?>><a href="painel.php"><i class="fa fa-dashboard"></i> Painel</a></li>
              <?php
                if ($_SESSION['tipo_usuario'] == 1) {
                  echo ((($pageTitle == "Cadastrar usuário") || ($pageTitle == "Usuários &middot; Visão Geral") || ($pageTitle == "Alterar usuário")) ? "<li class='active'>" : "<li>");
                  echo "<a href='usuarios.php'><i class='glyphicon glyphicon-user'></i> Usuários</a></li>";
                }
              ?>
             <li <?php if (($pageTitle == "Cadastrar ocorrência") || ($pageTitle == "Ocorrências &middot; Visão Geral")) echo "class='active'"; ?>><a href="ocorrencias.php"><i class="glyphicon glyphicon-tasks"></i> Ocorrências</a></li>
             <?php
                if (($_SESSION['tipo_usuario'] == 1) ||($_SESSION['tipo_usuario'] == 2)) {
                 echo ((($pageTitle == "Patrimônios &middot; Visão Geral") || ($pageTitle == "Cadastrar patrimônio")) ? "<li class='active'>" : "<li>");
                  echo "<a href='patrimonios.php'><i class='glyphicon glyphicon-edit'></i> Patrimônios</a></li>";
                }
              ?>
              <?php
                if (($_SESSION['tipo_usuario'] == 1) ||($_SESSION['tipo_usuario'] == 2)) {
                 echo ((($pageTitle == "Equipamentos &middot; Visão Geral") || ($pageTitle == "Cadastrar equipamento") || ($pageTitle == "Cadastrar categoria") || ($pageTitle == "Categorias") || ($pageTitle == "Alterar categoria")) ? "<li class='active'>" : "<li>");
                  echo "<a href='equipamentos.php'><i class='glyphicon glyphicon-hdd'></i> Equipamentos</a></li>";
                }
              ?>
              <?php
                if (($_SESSION['tipo_usuario'] == 1) ||($_SESSION['tipo_usuario'] == 2)) {
                 echo ((($pageTitle == "Imagens de disco rígido") || ($pageTitle == "Cadastrar imagem de disco rígido")) ? "<li class='active'>" : "<li>");
                  echo "<a href='imagens_HD.php'><i class='glyphicon glyphicon-floppy-disk'></i> Imagens de disco rígido</a></li>";
                }
              ?>
              
              <?php
                if (($_SESSION['tipo_usuario'] == 1) ||($_SESSION['tipo_usuario'] == 2)) {
                 echo ((($pageTitle == "Softwares") || ($pageTitle == "Cadastrar software")) ? "<li class='active'>" : "<li>");
                  echo "<a href='softwares.php'><i class='glyphicon glyphicon-th'></i> Softwares</a></li>";
                }
              ?>
              <?php
                if ($_SESSION['tipo_usuario'] == 1) {
                 //echo ((($pageTitle == "Relatórios")) ? "<li class='active'>" : "<li>");
                  //echo "<a href='relatorios.php'><i class='glyphicon glyphicon-file'></i> Relatórios</a></li>";
                }
              ?>
            </li>
          </ul>
          <?php
          $listaOcorrencia    = new Ocorrencia;
          $result     = $listaOcorrencia->notificarOcorrencias(0, $_SESSION['matricula'], $_SESSION['tipo_usuario']);
            if (is_array($result)) {
            foreach ($result as $row) {
              echo "<ul class='nav navbar-nav navbar-right navbar-user'>
              <li class='dropdown messages-dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-bell'></i> Notificações <span class='badge'>".$row['count']."</span> <b class='caret'></b></a>
              <ul class='dropdown-menu'>
           ";
          }
        }
          if (is_array($result)) {
            foreach ($result as $row) {
              if ($row['count']){
                echo " <li class='dropdown-header'>".$row['count']." Novas notificações</li>
                        <li class='message-preview'>
                        <a href='verOcorrencia.php?o=".$row['id']."'>
                          <span class='avatar'><img  style='width: 50px; height: 50px;' src='img/".$sessao->obterDados('avatar', $row['Usuario_matricula'])."'></span>
                          <span class='name'>".$row['nome']." ".$row['sobrenome']."</span>
                          <span class='message'>".truncate($row['descricao'], 5, 42)."</span>
                          <span class='time'><i class='glyphicon glyphicon-time'></i> ".date('H:i d/m/Y', strtotime($row['data_atualizacao']))."</span>
                        </a>
                      </li>";
                echo "<li class='divider'></li>
                      <li>
                        <a href='ocorrencias.php'>Ver todas <span class='badge'>".$row['count']."</span></a>
                      </li>";
              }  else {echo "<li class='message-preview'>Nenhuma notificação</li>";}
            }
          }
        ?>
              </ul>
            </li>
            <li class='dropdown user-dropdown'>
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='glyphicon glyphicon-user'></i> <?php echo $_SESSION['nome']." "; if(isset($_SESSION['sobrenome'])){echo $_SESSION['sobrenome'];} ?> <b class='caret'></b></a>
              <ul class='dropdown-menu'>
                <li><a href='perfil.php'><i class='glyphicon glyphicon-user'></i> Perfil</a></li>
                <?php
                if ($_SESSION['tipo_usuario'] == 1) {
                  echo "<li><a href='configuracoes.php'><i class='glyphicon glyphicon-cog'></i> Configurações</a></li>";
                }
                ?>
                <li class='divider'></li>
                <li><a href='logout.php'><i class='fa fa-power-off'></i> Sair</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
       <?php
      unset($listaOcorrencia);
      ?>
      <noscript id="noscript" class="container col-lg-12">
        Para uma melhor experiência no Restart, ative o JavaScript no seu navegador.
      </noscript>