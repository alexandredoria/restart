  
<?php
session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }
  $pageTitle  = "Patrimônios &middot; Visão Geral";
  
  include 'nucleo/cabecario.php';  
  include 'classes/patrimonio.class.php';
  
?>
<script language="JavaScript">

$(document).ready(function() {

    var $submit = $("#exc").hide(),
        $cbs = $('input[name="foo"]').click(function() {
            $submit.toggle( $cbs.is(":checked") );
        });
});

function toggle(source) {
  checkboxes = document.getElementsByName('foo');
  
  for (var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
    
  }
 

}

$(document).on("click", ".abre-excluirModal", function () {
     var IdPat = $(this).data('id');
     $(".modal-body #IdPatrimonio").val( IdPat );
});




</script>
  

      <!-- Barra Lateral -->
      <?php 
        include("nucleo/barraLateral.php");

        if (!empty($_POST)) {
          if (isset($_POST['IdPatrimonio'])) {
            $num_patrimonio   = $_POST['IdPatrimonio'];
           
            $objPatrimonio  = new Patrimonio;
            $objPatrimonio->deletarPatrimonio($num_patrimonio);
            unset($objPatrimonio);
          }
        }
      ?>

      <div id="page-wrapper">

       <div class="row">
           <div class="col-lg-6">
              <h1>Patrimônios <small>Visão geral</small></h1>
            </div>
            <div class="col-lg-6" align="right">
              <a href="cadPatrimonio.php"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i> Novo patrimônio</button></a>
            </div>      
       </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">            
            <ol class="breadcrumb">
               <li class="active"><i class="glyphicon glyphicon-user"></i> Patrimônios</li>
            </ol>
         
          </div>
        </div><!-- /.row -->


       <div class="row">
          <div class="col-lg-12">

            <table>
              <tr>
                  <th colspan="2"></th>
                  
              </tr>
              <tr>
                <td>
                  &nbsp;&nbsp;<input type='checkbox' id="toggle" onClick="toggle(this)">&nbsp;&nbsp;&nbsp;Exibição:&nbsp;
                </td>  
                <td>
                  <select style="font-weight:bold"  class="form-control">
                    <option value="todos">Todos</option>
                    <option value="bolsistas">Bolsistas</option>
                    <option value="professores">Professores</option>
                  </select>
                </td>
                <td>
                  &nbsp;&nbsp;
                  <button type="button" id="exc" class="btn btn-primary">
                    <i class='glyphicon glyphicon-remove'></i> Excluir
                  </button>
                </td>
              </tr>
            </table> 

            <div class="table-responsive">
              <table id="" class="table table-striped table-hover">
                <p>
                <tr>
                  <th></th>
                  
                  <th colspan="3">Operações</th>
                  <th>Registro</th>
                  <th>Tipo</th>
                  <th>Posição</th>
                  <th>Situação</th>
                  <th>Configuração</th>
                  <th>Laboratório</th>
                  <th>Data de cadastro</th>
                  <th>Data de atualização</th>
                  
                  

                </tr>
                
                <tbody>
                  <?php
                    

                    $listaPatrimonio    = new Patrimonio;
                    $result     = $listaPatrimonio->listarPatrimonios();
                    if (is_array($result)) {
                      foreach ($result as $row) {
                        if ($row['tipo'] == 1){
                          $tipo = "Monitor";
                        } if ( $row['tipo'] == 2){
                          $tipo = "Gabinete";
                        }

                        if ($row['situacao'] == '1'){
                          $situacao = "Ativo";
                        } if ( $row['situacao'] == '2'){
                          $situacao = "Desativado";
                        }
                        if($row['situacao'] == 2){echo "<tr id='fooTr'class='danger'>";} else echo "<tr id='fooTr'>";
                        echo "
                            <td ><input type='checkbox'   name='foo' value='".$row['num_patrimonio']."'></td>
                            <td>
                              <a title='Ver patrimônio' data-toggle='modal' data-id='".$row['num_patrimonio']."' href='#modal_verPatrimonio' class='abre-verModal'>                              
                                 <i class='glyphicon glyphicon-search'></i>
                               </a>
                            </td>

                            <td>
                              <a title='Editar patrimônio' data-toggle='modal' data-id='".$row['num_patrimonio']."' href='#modal_editPatrimonio' class='abre-editarModal'>                              
                                 <i class='glyphicon glyphicon-pencil'></i>
                               </a>
                            </td>

                            <td>
                              <a title='Excluir patrimônio' data-toggle='modal' data-id='".$row['num_patrimonio']."' href='#modal_excPatrimonio' class='abre-excluirModal'>                              
                                 <i class='glyphicon glyphicon-remove'></i>
                               </a>
                            </td>

                            
                            <td>" . $row['num_patrimonio'] . "</td>
                            <td>" . $tipo . "</td>
                            <td>" . $row['num_posicionamento'] . "</td>
                            <td>" . $situacao . "</td>
                            <td>" . $row['Configuracao_id'] . "</td>
                            <td>" . $row['Laboratorio_id'] . "</td>
                            <td>"; if ($row['data_cadastro']===null){echo "";} else {echo date('d/m/Y', strtotime($row['data_cadastro']));} echo "</td>
                            <td>"; if ($row['data_atualizacao']===null){echo date('d/m/Y', strtotime($row['data_cadastro']));} else {echo date('d/m/Y', strtotime($row['data_atualizacao']));} echo "</td>
                            
                            
                          </tr>"; 
                      }
                    } else echo 
                        " <tr>
                            <td></td>
                            <td>". $result."</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td> 
                          </tr>";
                    unset($listaUser);
                  ?>
                </tbody>
              
            </table></div>

          </div>
         
        </div><!-- /.row -->

        <!-- Button trigger modal -->
        <div class='modal fade' id='modal_excPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonioLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_cadPatrimonioLabel'>O patrimônio será excluído</h4>
      </div>
      <form role="form" id="confirm" action="patrimonios.php" method="post">
      <div class='modal-body'>
        
        Você realmente deseja executar essa operação?
        <input type="hidden" name="IdPatrimonio" id="IdPatrimonio" value=""/>
      </div>
       <div class="modal-footer">
        
            
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button type="submit" class="btn btn-danger">Sim</button>
        </form>
      </div>
    </div>
  </div>
</div>




      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    

  </body>
</html> 