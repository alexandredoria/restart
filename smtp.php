<?php
  include 'classes/usuario.class.php';
include 'classes/log.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/configuracao.class.php';

$pageTitle  = "SMTP";
  include 'nucleo/cabecario.php';
  include("nucleo/barraLateral.php");
  $configuracao = new Configuracao;
  $seguranca_smtp = $configuracao->obterDadosDB('seguranca_smtp');
?>
      <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1>SMTP</h1>
        </div>
      </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <li><a href="configuracoes.php"><i class="glyphicon glyphicon-cog"></i> Configurações</a></li>
        <li class="active"><i class="glyphicon glyphicon-envelope"></i> SMTP</li>
      </ol>
    </div>
  </div><!-- /.row -->
      <form role="form" class="validatedForm" id="perfil" action="perfil.php" method="post">
      <div class="row">
        <div class="col-lg-4">
            <input type="hidden" name="acao" value="atualiza">
            <div class="form-group">
              <label>Servidor SMTP</label>
              <input class="form-control" id="servidor_smtp" value="<?php echo $configuracao->obterDadosDB('servidor_smtp');?>" name="servidor_smtp" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Porta SMTP</label>
              <input type="text" class="form-control" value="<?php echo $configuracao->obterDadosDB('porta_smtp');?>" id="porta_smtp" name="porta_smtp" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Email SMTP</label>
              <input class="form-control" type="email"  value="<?php echo $configuracao->obterDadosDB('email_smtp');?>" id="email_smtp" name="email_smtp" required autocomplete="off">
            </div>
            <label>Segurança SMTP</label>
              <div class="form-group">
                    <div class="radio">
                      <input type="radio" name="seguranca_SMTP" <?php if ($seguranca_smtp == "SSL" ){echo "checked='checked'";}?> id="seguranca_smtp">
                      <label>SSL</label>
                    </div>
                  <div class="radio">
                    <input type="radio" name="seguranca_SMTP" id="seguranca_smtp">
                    <label>TLS</label>
                  </div>
              </div>
          </div>
        <div class="col-lg-4">
            <div class="form-group">
              <label>Usuário SMTP</label>
              <input class="form-control" type="text" id="user_smtp" name="user_smtp" value="<?php echo $configuracao->obterDadosDB('usuario_smtp');?>"  required autocomplete="off">
            </div>
            <div class="radio">
              <br>
                <input type="radio" name="seguranca_smtp" id="seguranca_smtp" value="0" onClick="Disab(this.value)" checked>
                <input type="hidden" id="antigasenha" name="antigasenha">
                <label> Desejo continuar com a mesma senha SMTP</label>
            </div>
              <div class="form-group">
                  <label>
                  <div class="radio">
                    <input type="radio" name="seguranca_smtp" id="seguranca_smtp" value="1"  onClick="Disab(this.value)">
                    <input class="form-control" type="password" maxlength="10" id="novasenha" placeholder="Nova senha" name="novasenha" required autocomplete="off">
                    <input class="form-control" type="password" maxlength="10" placeholder="Confirma" id="confirma" name="confirmsenha" required autocomplete="off">
                  </div>
                  </label>
              </div>
            <div class="form-group" align="right"><br>
              <button type="submit" class="btn btn-default">Atualizar</button>
              <button type="reset" class="btn btn-default">Desfazer</button>
            </div>
        </div>
        <div class="col-lg-4">
        </div>
      </div><!-- /.row -->
      </form>
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
<?php
unset($configuracao);?>