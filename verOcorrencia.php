
<?php
include 'classes/usuario.class.php';
include 'classes/ocorrencia.class.php';
include 'classes/patrimonio.class.php';
include 'classes/laboratorio.class.php';
include 'classes/categoria.class.php';
include 'classes/defeito.class.php';
include 'classes/log.class.php';
if (isset($_GET['o'])){$idOcorrencia = $_GET['o'];}
$ocorrencia = new Ocorrencia;
$usuario = new Usuario;
$patrimonio = new Patrimonio;
$laboratorio = new laboratorio;
$categoria = new Categoria;
$LOG = new Log;
$estado_servico = $ocorrencia->obterDados('estado_servico', $idOcorrencia);
$solicitante = $ocorrencia->obterDados('Usuario_matricula', $idOcorrencia);
$nomeSolicitante = $usuario->obterDados('nome', $solicitante)." ".$usuario->obterDados('sobrenome', $solicitante);
$avatarSolicitante = $usuario->obterDados('avatar', $solicitante);
$descricao = $ocorrencia->obterDados('descricao', $idOcorrencia);
$num_patrimonio = $ocorrencia->obterDados('Patrimonio_num_patrimonio', $idOcorrencia);
$lab = $patrimonio->obterDados('Laboratorio_id', $num_patrimonio);
$num_posicionamento = $patrimonio->obterDados('num_posicionamento', $num_patrimonio);
$cat = $patrimonio->obterDados('Categoria_id', $num_patrimonio);
$cat = $categoria->obterDados('nome', $cat);
$lab = $laboratorio->obterDados('nome', $lab);
$data_cadastro = $ocorrencia->obterDados('data_cadastro', $idOcorrencia);
$data_cadastro = date('H:i d/m/Y', strtotime($data_cadastro));
if ($ocorrencia->obterDados('data_atualizacao', $idOcorrencia) != NULL){
  $data_atualizacao = $ocorrencia->obterDados('data_atualizacao', $idOcorrencia);
  $data_atualizacao = date('H:i d/m/Y', strtotime($data_atualizacao));
}
if (($ocorrencia->obterDados('data_previa', $idOcorrencia) != NULL) && ($estado_servico = 2)){
  $data_previa = $ocorrencia->obterDados('data_previa', $idOcorrencia);
  $data_previa = date('H:i d/m/Y', strtotime($data_previa));
}
if (($ocorrencia->obterDados('data_entrega', $idOcorrencia) != NULL) && ($estado_servico = 3)){
  $data_entrega = $ocorrencia->obterDados('data_entrega', $idOcorrencia);
  $data_entrega = date('H:i d/m/Y', strtotime($data_entrega));
}
if ($ocorrencia->obterDados('data_atendimento', $idOcorrencia) != NULL ){
  $data_atendimento = $ocorrencia->obterDados('data_atendimento', $idOcorrencia);
  $data_atendimento = date('H:i d/m/Y', strtotime($data_atendimento));
}
if ($ocorrencia->obterDados('bolsista_alocado', $idOcorrencia) != NULL ){
  $bolsista_alocado = $ocorrencia->obterDados('bolsista_alocado', $idOcorrencia);
  $avatarBolsista = $usuario->obterDados('avatar', $bolsista_alocado);
  $nomeBolsista = $usuario->obterDados('nome', $bolsista_alocado)." ".$usuario->obterDados('sobrenome', $bolsista_alocado);
} else {
  $bolsista_alocado = "Nenhum";
  $avatarBolsista = "default_130x130.png";
  $nomeBolsista = "Nenhum";
}
$pageTitle  = "Ocorrência ".$idOcorrencia;
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if(isset($_POST['assumir'])){
  if (isset($_POST['data_previa'])){
    $data_previa = $_POST['data_previa'];
    $result = $ocorrencia->assumirOcorrencia($idOcorrencia, $_SESSION['matricula'], $data_previa);
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ASS_OCO', $result);
    header("Location: ../restart/verOcorrencia.php?o=$idOcorrencia");
  } else {$result = "Insira a prévia da data de entrega";}
} else if(isset($_POST['fechar'])){
  if (isset($_POST['defeito'])){
    $defeito = $_POST['defeito'];
    $result = $ocorrencia->fecharOcorrencia($idOcorrencia, $defeito);
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'FEC_OCO', $result);
    header("Location: ../restart/verOcorrencia.php?o=$idOcorrencia");
  }  
} else if(isset($_POST['reabrir'])){
  $result = $ocorrencia->reabrirOcorrencia($idOcorrencia);
  $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'REA_OCO', $result);
  header("Location: ../restart/verOcorrencia.php?o=$idOcorrencia");
}
if (isset($_POST['idOcoExcluir'])) {
  $id   = $_POST['idOcoExcluir'];
  $objOcorrencia  = new Ocorrencia;
  $resultado = $objOcorrencia->deletarOcorrencia($id);
  if (is_bool($resultado)) {
    echo "<!-- Modal -->
    <div class='modal fade bs-modal-sm' id='modal_excOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciaLabel' aria-hidden='true'>
    <div class='modal-dialog modal-sm'>
    <div class='modal-content panel-success'>
    <div class='modal-header panel-heading'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h4 class='modal-title' id='modal_excOcorrenciaLabel'>Ocorrência excluída!</h4>
    </div>
    </div>
    </div>
    </div>";
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_OCO', $resultado);
  }
  else {
    echo "<!-- Modal -->
    <div class='modal fade' id='modal_excOcorrencia' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciaLabel' aria-hidden='true'>
    <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
    <div class='modal-header panel-heading'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h4 class='modal-title' id='modal_excOcorrenciaLabel'>Não foi possível excluir a ocorrência</h4>
    </div>
    <div class='modal-body'>
    <p>".$resultado."</p>
    <br><br><p><b>Contate à COLINF</b></p>
    </div>
    </div>
    </div>
    </div>";
  }
  unset($objOcorrencia);
  echo "<script>$('#modal_excOcorrencia').modal('show');</script>";
  header("Location: ../restart/ocorrencias.php");
}
echo "
<div id='page-wrapper'>
<div class='row'>
<div class='col-lg-12'>
<h1> Ocorrência ".$idOcorrencia."</h1>
<ol class='breadcrumb'>
<li><a href='ocorrencias.php'><i class='glyphicon glyphicon-tasks'></i> Ocorrências</a></li>
<li class='active'><i class='glyphicon glyphicon-search'></i> Ocorrência ".$idOcorrencia."</li>
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
<div class='form-group'>
<label>Solicitante</label>
<div class='media'>
<a class='pull-left' href='verUsuario.php?m=".$solicitante."'>
<img class='media-object' style='width: 50px; height: 50px;' src='img/".$avatarSolicitante."' alt='".$nomeSolicitante."'>
</a>
<div class='media-body'>
<a href='verUsuario.php?m=".$solicitante."'>
<h4 class='media-heading'>".$nomeSolicitante."</h4>
Matrícula ".$solicitante."
</a>
</div>
</div>
</div>
<br>
<div class='form-group'>
<i class='glyphicon glyphicon-comment'></i> <label>Descrição</label>
<br>
<blockquote>".$descricao."</blockquote>
</div>
<div class='form-group'>
<i class='glyphicon glyphicon-map-marker'></i> <label>".$lab."</label>
</div>
<div class='form-group'>
<i class='glyphicon glyphicon-edit'></i> <label>".$cat." nº ".$num_patrimonio."</label>
</div>
<div class='form-group'>
<i class='glyphicon glyphicon-screenshot'></i> <label> Posição ".$num_posicionamento."</label>
</div>
</div>
<div class='col-lg-4'>";
if ($bolsista_alocado != "Nenhum") {
  echo "
  <div class='form-group'>
  <label>Bolsista alocado</label>
  <div class='media'>
  <a class='pull-left' href='verUsuario.php?m=".$bolsista_alocado."'>
  <img class='media-object' style='width: 50px; height: 50px;' src='img/".$avatarBolsista."' alt='".$nomeBolsista."'>
  </a>
  <div class='media-body'>
  <a href='verUsuario.php?m=".$bolsista_alocado."'>
  <h4 class='media-heading'>".$nomeBolsista."</h4>
  Matrícula ".$bolsista_alocado."
  </a>
  </div>
  </div>
  </div>";
} else {
  echo "
  <div class='form-group'>
  <label>Bolsista alocado</label>
  <div class='media'>
  <a class='pull-left'>
  <img class='media-object' style='width: 50px; height: 50px;' src='img/".$avatarBolsista."' alt='".$nomeBolsista."'>
  </a>
  <div class='media-body'>
  <h4 class='media-heading'>".$nomeBolsista."</h4>
  </div>
  </div>
  </div>";
}
echo "
</div>
<div class='col-lg-4'>
<div class='form-group'>";
if ($estado_servico == 1){ echo "<h4 style='color:#EEC900;'>Ocorrência aberta</h4>";}
else if ($estado_servico == 2) { echo "<h4 style='color:#00CD00;'>Ocorrência em andamento</h4>";}
else if ($estado_servico == 3) { echo "<h4 style='color:#838B83;'>Ocorrência fechada</h4>";}
else if ($estado_servico == 4) { echo "<h4 style='color:#CD2626;'>Ocorrência incompleta</h4>";}
echo "</div>
<div class='form-group'>
<i class='glyphicon glyphicon-time'></i> <label> Data de cadastro</label><br>
".$data_cadastro."
</div>";
if (isset($data_atualizacao)){
  echo
  "<div class='form-group'>
  <i class='glyphicon glyphicon-time'></i> <label> Data de atualizacao</label><br>
  ".$data_atualizacao."
  </div>";
}
if (isset($data_atendimento)){
  echo
  "<div class='form-group'>
  <i class='glyphicon glyphicon-time'></i> <label> Data de atendimento</label><br>
  ".$data_atendimento."
  </div>";
}
if (isset($data_previa)){
  echo
  "<div class='form-group'>
  <i class='glyphicon glyphicon-time'></i> <label> Prévia de entrega</label><br>
  ".$data_previa."
  </div>";
}
if (isset($data_entrega)){
  echo
  "<div class='form-group'>
  <i class='glyphicon glyphicon-time'></i> <label> Data de entrega</label><br>
  ".$data_entrega."
  </div>";
}
echo "<form action='verOcorrencia.php?o=$idOcorrencia' method='post'>";
if ($solicitante == $_SESSION['matricula']) {
  if (($estado_servico == 1) || ($estado_servico == 2) || ($estado_servico == 4)) {
    echo"
    <div class='form-group'>
    <a title='Editar ocorrência'  href='alterarOcorrencia.php?o=".$idOcorrencia."'>
    <button type='button' class='btn btn-default'>
    <i class='glyphicon glyphicon-pencil'></i> Editar
    </button>
    </a>
    </div>
    <div class='form-group'>
    <a title='Excluir ocorrência' data-toggle='modal' data-id='".$idOcorrencia."' href='#modal_excOcorrenciaSimples' class='abre-excluirModal'>
    <button type='button' class='btn btn-danger'>
    <i class='glyphicon glyphicon-remove'></i> Excluir
    </button>
    </a>
    </div>
    ";
  } else if ($estado_servico == 3){
    echo "
    <div class='form-group'>
    <button type='submit' name='reabrir' class='btn btn-danger'>
    <i class='glyphicon glyphicon-share'></i> Reabrir
    </button>
    </div>
    <div class='form-group'>
    </div>";
  }
}
if ($_SESSION['tipo_usuario'] == 2){
  if ($estado_servico == 1)  {
   if (isset($erro)){ echo "<div id='login_error' style='color:#D00000;'>".$erro."</div>";}else{echo "<br>";}
   echo"
   <div class='form-group'>
   <button type='submit' name='assumir' class='btn btn-warning'>
   <!-- <a title='Assumir ocorrência' href='assumirOcorrencia.php?o=".$idOcorrencia."' onclick='this.form.submit()'>  -->
   <i class='glyphicon glyphicon-thumbs-up'></i> Assumir
   </button>
   <!--</a>-->
   </div>
   <div class='form-group'>
   <div class='input-group'>
   <i class='glyphicon glyphicon-calendar input-group-addon'> </i>
   <input id='data_previa' placeholder='Prévia de entrega' data-date-format='dd-mm-yyyy' name='data_previa' type='text' class='date-picker form-control' data-date-language='pt-BR' required autocomplete='off' />
   </div>
   </div>";
 }
 if ($bolsista_alocado == $_SESSION['matricula']) {
  if (($estado_servico == 2) || ($estado_servico == 4)){
    echo"
    <div class='form-group'>
    <a title='Rejeitar ocorrência'  href='rejeitarOcorrencia.php?o=".$idOcorrencia."'>
    <button type='button' class='btn btn-default'>
    <i class='glyphicon glyphicon-thumbs-down'></i> Rejeitar
    </button>
    </a>
    </div>
    <div class='form-group'>
    <button type='submit' name='fechar' class='btn btn-success'>
    <i class='glyphicon glyphicon-check'></i> Fechar
    </button>
    </div>
    <div class='form-group'>
    <select multiple id='defeito[]' name='defeito[]'class='form-control' required>
    <option value=''>Selecione um ou mais defeitos</option>";
    $def = new Defeito;
    $result = $def->listarDefeitos(0);
    foreach ($result as $row) {
      echo " <option value='".$row['id']."'> ".$row['detalhe']."</option>";
    }
    unset($def);
    echo"
    </select>
    </div>";
  } else if ($estado_servico == 3) {
    echo "
    <div class='form-group'>
    </div>
    <div class='form-group'></div>";
  }
} else if  ($bolsista_alocado != $_SESSION['matricula']){
  echo "
  <div class='form-group'></div>";
}
} else if ($_SESSION['tipo_usuario'] != 2){
  if ($solicitante != $_SESSION['matricula']){
    echo "
    <div class='form-group'></div>
    <div class='form-group'></div>";
  }
}
echo"</form>";
echo "
</div>
</div><!-- /.row -->
</div><!-- /#page-wrapper -->";
unset($ocorrencia);
unset($usuario);
unset($patrimonio);
unset($laboratorio);
unset($LOG);
unset($categoria);
?>
<div class='modal fade' id='modal_excOcorrenciaSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excOcorrenciasSimplesLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_excUsuarioLabel'>O usuário será excluído</h4>
      </div>
      <div class='modal-body'>
        Você realmente deseja excluir ocorrência?
      </div>
      <div class="modal-footer">
        <form id="confirm" method="POST" action="verOcorrencia.php?o=<?php echo $idOcorrencia;?>">
          <input type="hidden" name="idOcoExcluir" id="idOcoExcluir" value=""/>
          <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
          <button id="submit-modal" class="btn btn-danger">Sim</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).on("click", ".abre-excluirModal", function () {
 var idPat = $(this).data('id');
 $(".modal-footer #idOcoExcluir").val(idPat);
});
$('#data_previa').datepicker({
  startDate: '0',
  endDate: '+7d',
});
$(".date-picker").datepicker();
$('.datepicker').datepicker({ language: "pt-BR" });
$(".date-picker").on("change", function () {
  var id = $(this).attr("id");
  var val = $("label[for='" + id + "']").text();
  $("#msg").text(val + " changed");
});
function submit()
{
 document.forms["ocorrencia"].submit();
}
</script>
</div><!-- /#wrapper -->
</body>
</html>