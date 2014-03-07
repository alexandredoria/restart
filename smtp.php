<?php

  include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "SMTP";
  
  include 'nucleo/cabecario.php';
  include("nucleo/barraLateral.php");
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
      <form role="form" class="validatedForm"  id="perfil" action="perfil.php" method="post">
      <div class="row">
        <div class="col-lg-4">
          
            <input type="hidden" name="acao" value="atualiza">
            <div class="form-group">
              <label>Servidor SMTP</label>
              <input class="form-control" id="sobrenome" name="sobrenome" required autocomplete="off">          
            </div> 
            <div class="form-group">
              <label>Porta SMTP</label>
              <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
            </div>
            <div class="form-group">
              <label>Email SMTP</label>
              <input class="form-control" type="text" id="telefone_residencial" name="telefone_residencial" data-mask="(99) 9999-9999" required autocomplete="off">
            </div>  
            <label>Segurança SMTP</label>
              <div class="form-group">
                    <div class="radio">             
                      <input type="radio" name="seguranca_SMTP" id="senhaRadio">
                      <label>SSL</label>
                    </div>  
                  <div class="radio">
                    <input type="radio" name="seguranca_SMTP" id="senhaRadio">
                    <label>TLS</label>
                  </div>
              </div>

          </div>
        <div class="col-lg-4">
          
            
            <div class="form-group">
              <label>Usuário SMTP</label>
              <input class="form-control" type="text" id="telefone_celular" name="telefone_celular" data-mask="(99) 9999-9999" required autocomplete="off">               
            </div>
            <div class="radio">
              <br>
                <input type="radio" name="senhaRadio" id="senhaRadio" value="0" onClick="Disab(this.value)" checked>
                <input type="hidden" id="antigasenha" name="antigasenha">
                <label> Desejo continuar com a mesma senha SMTP</label>
            </div>                   
            
              <div class="form-group">
                  <label>
                  <div class="radio">
                    <input type="radio" name="senhaRadio" id="senhaRadio" value="1"  onClick="Disab(this.value)">
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
