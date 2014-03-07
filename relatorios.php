  
<?php 
include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
$pageTitle  = "Relatórios"; 
  include 'nucleo/cabecario.php';    
  include("nucleo/barraLateral.php");
  
  if ($_SESSION['tipo_usuario'] != 1){
    header("Location: ../restart/painel.php");
    exit;

  }
  if (isset($_POST['filtro'])){
      $filtro = $_POST['filtro'];
  } else {
    $filtro = 0;
  }
  if (!empty($_POST)) {
    //MODELO COM ARRAY
    /*if (isset($_POST['matUsuario'])) {
      $del_matricula   = $_POST['matUsuario'];
    } else if (isset($_POST['checkbox'])){
      $del_matricula = $_POST['checkbox'];
      $sql = implode ("','", array($_POST['checkbox']));
      $del_matricula = $sql;
    }
      $delUser  = new Usuario;
      $delUser->deletarUsuario($del_matricula);
      unset($delUser);
*/

    
    //MODELO SIMPLES
    if (isset($_POST['matUsuario'])) {
      $del_matricula   = $_POST['matUsuario'];
       $delUser  = new Usuario;
       $result = $delUser->deletarUsuario($del_matricula);
        if (is_bool($result)) {
              echo "<!-- Modal -->
                    <div class='modal fade bs-modal-sm' id='modal_excUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-sm'>
                        <div class='modal-content panel-success'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excUsuarioLabel'>Usuário excluído!</h4>
                          </div>
                          
                        </div>
                      </div>
                    </div>";
            }
            else {
              echo "<!-- Modal -->
                    <div class='modal fade' id='modal_excUsuario' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioLabel' aria-hidden='true'>
                      <div class='modal-dialog'>
                        <div class='modal-content panel-danger'>
                          <div class='modal-header panel-heading'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='modal_excUsuarioLabel'>Não foi possível excluir o usuário</h4>
                          </div>
                          <div class='modal-body'>
                            <p>".$result."</p>
<br><br><p><b>Contate à COLINF</b></p>
                          </div>
                        </div>
                      </div>
                    </div>";
            }
      unset($delUser);
       echo "<script>$('#modal_excUsuario').modal('show');</script>";
    } 
  }
?>
<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-6">
      <h1>Relatórios</h1>
    </div>
    <div class="col-lg-6" align="right">
    </div>      
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">            
      <ol class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-file"></i> Relatórios</li>
      </ol>
    </div>
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Ocorrências por período
        </label>
        <div class="row">
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="De" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="Até" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3"> 
            <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option  value="0">Todos</option>
              <option  value="1">Abertos</option>
              <option  value="2">Em andamento</option>
              <option  value="3">Fechados</option>
              <option  value="4">Incompletos</option>
            </select>        
          </div>
          <div class="col-lg-3">  
          </div> 
        </div><!--row-->
      </div><!--checkbox-->
    </div><!--col-lg-12-->
  </div> <!--row-->     
  <div class="row">
    <div class="col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Principais defeitos e problemas
        </label>
        <div class="row">
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="De" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="Até" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">
            <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option  value="0">Todos</option>
              <option  value="1">Hardwares</option>
              <option  value="3">Softwares</option>
            </select>                    
          </div>
          <div class="col-lg-3">  
          </div> 
        </div><!--row-->
      </div><!--checkbox-->
    </div><!--col-lg-12-->
  </div> <!--row-->      
  <div class="row">
    <div class="col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Usuários mais ativos
        </label>
        <div class="row">
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="De" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="Até" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">  
          <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option  value="0">Todos</option>
              <option  value="2">Bolsistas</option>
              <option  value="3">Professores</option>
            </select>       
          </div>
          <div class="col-lg-3">  
          </div> 
        </div><!--row-->
      </div><!--checkbox-->
    </div><!--col-lg-12-->
  </div> <!--row--> 
  <div class="row">
    <div class="col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Bens de patrimônios
        </label>
        <div class="row">
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="De" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="Até" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">
          <select style="font-weight:bold" id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
              <option  value="0">Todos</option>
              <option  value="1">Gabinetes</option>
              <option  value="2">Monitores</option>
              <option  value="3">Estabilizadores</option>
              <option  value="4">Nobreaks</option>
              <option  value="5">Mesas</option>              
              <option  value="6">Cadeiras</option>
              <option  value="7">Ar-condicionadores</option>
              <option  value="8">Armários</option>
              <option  value="9">Projetores</option>
            </select>         
          </div>
          <div class="col-lg-3">  
          </div> 
        </div><!--row-->
      </div><!--checkbox-->
    </div><!--col-lg-12-->
  </div> <!--row-->
  <div class="row">
    <div class="col-lg-12">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Vencimento da garantia dos equipamentos
        </label>
        <div class="row">
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="De" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">       
            <div class="input-group">                  
              <i class="glyphicon glyphicon-calendar input-group-addon"> </i>
              <input id="date-picker-1" placeholder="Até" name="date-picker-1" type="text" class="date-picker form-control" data-date-language="pt-BR" />
            </div> 
          </div>
          <div class="col-lg-3">         
          </div>
          <div class="col-lg-3">  
          </div> 
        </div><!--row-->
      </div><!--checkbox-->
    </div><!--col-lg-12-->
  </div> <!--row-->
          
    


    <div class='modal fade' id='modal_excUsuarioSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excUsuarioSimplesLabel' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content panel-danger'>
          <div class='modal-header panel-heading'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h4 class='modal-title' id='modal_excUsuarioLabel'>O usuário será excluído</h4>
          </div>
          <div class='modal-body'>
            Você realmente deseja excluir a conta relacionada à matrícula?
          </div>
          <div class="modal-footer">
            <form id="confirm" method="post" action="usuarios.php">
              <input type="hidden" name="matUsuario" id="matUsuario" value=""/>
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
              <button id="submit-modal" class="btn btn-danger">Sim</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->

<script language="JavaScript">
  $(document).ready(function() {

	  
	    
    var $submit = $("#exc").hide(),

    $cbs = $('input[name="foo[]"]').click(function() {

      $submit.toggle( $cbs.is(":checked") );
	 var count=0;
	checkboxes = document.getElementsByName('foo[]');
	for (var i=0, n=checkboxes.length;i<n;i++) {
      if(checkboxes[i].checked)
	  {
		  count = count+1;} 
     	}
	  if (count!=checkboxes.length) { $("#toggle").prop('checked',false);}	
	  else{ $("#toggle").prop('checked',true);}
    });

		
	
  });

  function toggle(source) {
	
    checkboxes = document.getElementsByName('foo[]');
    for (var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked; 
	}$("#exc").toggle('show');
	}
  
  window.addEventListener("DOMContentLoaded", function () {
    var confirm = document.getElementById("confirm");
    document.getElementById("submit-modal").addEventListener("click", function () {
      confirm.submit();
    });
  });

  $(document).on("click", ".abre-excluirModal", function () {
     var matUser = $(this).data('id');
     $(".modal-footer #matUsuario").val(matUser);
});


  $(".date-picker").datepicker();
  $('.datepicker').datepicker({ language: "pt-BR" });

$(".date-picker").on("change", function () {
    var id = $(this).attr("id");
    var val = $("label[for='" + id + "']").text();
    $("#msg").text(val + " changed");
});




</script>
</body>
</html>