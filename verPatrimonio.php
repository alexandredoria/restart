
<?php
include 'classes/usuario.class.php';
include 'classes/patrimonio.class.php';
include 'classes/laboratorio.class.php';
include 'classes/categoria.class.php';
include 'classes/defeito.class.php';
include 'classes/imagem_hd.class.php';
include 'classes/log.class.php';
if (isset($_GET['p'])){$idPatrimonio = $_GET['p'];}
$patrimonio = new Patrimonio;
$usuario = new Usuario;
$laboratorio = new laboratorio;
$categoria = new Categoria;
$equipamento = new Equipamento;
$imagem_hd = new Imagem_HD;

$situacao_pat = $patrimonio->obterDados('situacao', $idPatrimonio);
$num_posicionamento_pat = $patrimonio->obterDados('num_posicionamento', $idPatrimonio);
$data_cadastro_pat = $patrimonio->obterDados('data_cadastro', $idPatrimonio);
$data_atualizacao_pat = $patrimonio->obterDados('data_atualizacao', $idPatrimonio);
$equipamento_id_pat = $patrimonio->obterDados('Equipamento_id', $idPatrimonio);
$categoria_id_pat = $patrimonio->obterDados('Categoria_id', $idPatrimonio);
$laboratorio_id_pat = $patrimonio->obterDados('Laboratorio_id', $idPatrimonio);

$nome_lab = $laboratorio->obterDados('nome', $laboratorio_id_pat);

$nome_cat = $categoria->obterDados('nome', $categoria_id_pat);


$categoria_id_equip = $equipamento->obterDados('Categoria_id', $equipamento_id_pat);
$imagem_hd_equip = $equipamento->obterDados('Imagem_HD_id', $equipamento_id_pat);
$modelo_equip = $equipamento->obterDados('modelo', $equipamento_id_pat);
$modelo_processador_equip = $equipamento->obterDados('modelo_processador', $equipamento_id_pat);
$capacidade_ram_equip = $equipamento->obterDados('capacidade_ram', $equipamento_id_pat);
$capacidade_hd_equip = $equipamento->obterDados('capacidade_hd', $equipamento_id_pat);
$vencimento_garantia_equip = $equipamento->obterDados('vencimento_garantia', $equipamento_id_pat);

$nome_arquivo_ima = $imagem_hd->obterDados('nome_arquivo', $Imagem_HD_id);
$data_criacao_ima = $imagem_hd->obterDados('data_criacao', $Imagem_HD_id);
$data_atualizacao = $imagem_hd->obterDados('data_atualizacao', $Imagem_HD_id);




















$num_posicionamento = $patrimonio->obterDados('num_posicionamento', $num_patrimonio);
$cat = $patrimonio->obterDados('Categoria_id', $num_patrimonio);
$cat = $categoria->obterDados('nome', $cat);
$lab = $laboratorio->obterDados('nome', $lab);
$data_cadastro = $patrimonio->obterDados('data_cadastro', $idPatrimonio);
$data_cadastro = date('H:i d/m/Y', strtotime($data_cadastro));
if ($patrimonio->obterDados('data_atualizacao', $idPatrimonio) != NULL){
  $data_atualizacao = $patrimonio->obterDados('data_atualizacao', $idPatrimonio);
  $data_atualizacao = date('H:i d/m/Y', strtotime($data_atualizacao));
}
if (($patrimonio->obterDados('data_previa', $idPatrimonio) != NULL) && ($estado_servico = 2)){
  $data_previa = $patrimonio->obterDados('data_previa', $idPatrimonio);
  $data_previa = date('H:i d/m/Y', strtotime($data_previa));
}
if (($patrimonio->obterDados('data_entrega', $idPatrimonio) != NULL) && ($estado_servico = 3)){
  $data_entrega = $patrimonio->obterDados('data_entrega', $idPatrimonio);
  $data_entrega = date('H:i d/m/Y', strtotime($data_entrega));
}
if ($patrimonio->obterDados('data_atendimento', $idPatrimonio) != NULL ){
  $data_atendimento = $patrimonio->obterDados('data_atendimento', $idPatrimonio);
  $data_atendimento = date('H:i d/m/Y', strtotime($data_atendimento));
}
if ($patrimonio->obterDados('bolsista_alocado', $idPatrimonio) != NULL ){
  $bolsista_alocado = $patrimonio->obterDados('bolsista_alocado', $idPatrimonio);
  $avatarBolsista = $usuario->obterDados('avatar', $bolsista_alocado);
  $nomeBolsista = $usuario->obterDados('nome', $bolsista_alocado)." ".$usuario->obterDados('sobrenome', $bolsista_alocado);
} else {
  $bolsista_alocado = "Nenhum";
  $avatarBolsista = "default_130x130.png";
  $nomeBolsista = "Nenhum";
}
$pageTitle  = "Patrimônio ".$idPatrimonio;
include 'nucleo/cabecario.php';
include 'nucleo/barraLateral.php';
if(isset($_POST['assumir'])){
  if (isset($_POST['data_previa'])){
    $data_previa = $_POST['data_previa'];
    $result = $patrimonio->assumirPatrimonio($idPatrimonio, $_SESSION['matricula'], $data_previa);
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'ASS_OCO', $result);
    header("Location: ../restart/verPatrimonio.php?o=$idPatrimonio");
  } else {$result = "Insira a prévia da data de entrega";}
} else if(isset($_POST['fechar'])){
  if (isset($_POST['defeito'])){
    $defeito = $_POST['defeito'];
    $result = $patrimonio->fecharPatrimonio($idPatrimonio, $defeito);
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'FEC_OCO', $result);
    header("Location: ../restart/verPatrimonio.php?o=$idPatrimonio");
  }  
} else if(isset($_POST['reabrir'])){
  $result = $patrimonio->reabrirPatrimonio($idPatrimonio);
  $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'REA_OCO', $result);
  header("Location: ../restart/verPatrimonio.php?o=$idPatrimonio");
}
if (isset($_POST['idOcoExcluir'])) {
  $id   = $_POST['idOcoExcluir'];
  $objPatrimonio  = new Patrimonio;
  $resultado = $objPatrimonio->deletarPatrimonio($id);
  if (is_bool($resultado)) {
    echo "<!-- Modal -->
    <div class='modal fade bs-modal-sm' id='modal_excPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonioLabel' aria-hidden='true'>
    <div class='modal-dialog modal-sm'>
    <div class='modal-content panel-success'>
    <div class='modal-header panel-heading'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h4 class='modal-title' id='modal_excPatrimonioLabel'>Patrimônio excluída!</h4>
    </div>
    </div>
    </div>
    </div>";
    $LOG->gerarLOG($_SESSION['matricula'], $_SERVER['REMOTE_ADDR'], 'DEL_OCO', $resultado);
  }
  else {
    echo "<!-- Modal -->
    <div class='modal fade' id='modal_excPatrimonio' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimonioLabel' aria-hidden='true'>
    <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
    <div class='modal-header panel-heading'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
    <h4 class='modal-title' id='modal_excPatrimonioLabel'>Não foi possível excluir a patrimônio</h4>
    </div>
    <div class='modal-body'>
    <p>".$resultado."</p>
    <br><br><p><b>Contate à COLINF</b></p>
    </div>
    </div>
    </div>
    </div>";
  }
  unset($objPatrimonio);
  echo "<script>$('#modal_excPatrimonio').modal('show');</script>";
  header("Location: ../restart/patrimonios.php");
}
echo "
<div id='page-wrapper'>
<div class='row'>
<div class='col-lg-12'>
<h1> Patrimônio ".$idPatrimonio."</h1>
<ol class='breadcrumb'>
<li><a href='patrimonios.php'><i class='glyphicon glyphicon-tasks'></i> Patrimônios</a></li>
<li class='active'><i class='glyphicon glyphicon-search'></i> Patrimônio ".$idPatrimonio."</li>
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
if ($estado_servico == 1){ echo "<h4 style='color:#EEC900;'>Patrimônio aberta</h4>";}
else if ($estado_servico == 2) { echo "<h4 style='color:#00CD00;'>Patrimônio em andamento</h4>";}
else if ($estado_servico == 3) { echo "<h4 style='color:#838B83;'>Patrimônio fechada</h4>";}
else if ($estado_servico == 4) { echo "<h4 style='color:#CD2626;'>Patrimônio incompleta</h4>";}
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
echo "<form action='verPatrimonio.php?o=$idPatrimonio' method='post'>";
if ($solicitante == $_SESSION['matricula']) {
  if (($estado_servico == 1) || ($estado_servico == 2) || ($estado_servico == 4)) {
    echo"
    <div class='form-group'>
    <a title='Editar patrimônio'  href='alterarPatrimonio.php?o=".$idPatrimonio."'>
    <button type='button' class='btn btn-default'>
    <i class='glyphicon glyphicon-pencil'></i> Editar
    </button>
    </a>
    </div>
    <div class='form-group'>
    <a title='Excluir patrimônio' data-toggle='modal' data-id='".$idPatrimonio."' href='#modal_excPatrimonioSimples' class='abre-excluirModal'>
    <button type='button' class='btn btn-danger'>
    <i class='glyphicon glyphicon-remove'></i> Excluir
    </button>
    </a>
    </div>
    ";
  } else if ($estado_servico == 3){
    echo "<div class='form-group'><label><i class='glyphicon glyphicon-warning-sign'></i> Defeitos encontrados</label><br>";
    $defeitos = $patrimonio->exibirDefeito($idPatrimonio);
    
    foreach ($defeitos as $row){
      $nomeDefeito = $patrimonio->nomeDefeito($row['Defeito_id']);
      foreach ($nomeDefeito as $linha){
        if ($linha['categoria'] == 1){$categoria = "Hardware";}
        else if ($linha['categoria'] == 2){$categoria = "Software";}
        echo $categoria." - ".$linha['detalhe']."<br>";
      }  

    }
    
    echo "</div>";
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
   <!-- <a title='Assumir patrimônio' href='assumirPatrimonio.php?o=".$idPatrimonio."' onclick='this.form.submit()'>  -->
   <i class='glyphicon glyphicon-thumbs-up'></i> Assumir
   </button>
   <!--</a>-->
   </div>
   <div class='form-group'>
   <div class='input-group'>
   <i class='glyphicon glyphicon-calendar input-group-addon'> </i>
   <input id='data_previa' placeholder='Prévia de entrega' data-date-format='yyyy-mm-dd' name='data_previa' type='text' class='date-picker form-control' data-date-language='pt-BR' required autocomplete='off' />
   </div>
   </div>";
 }
 if ($bolsista_alocado == $_SESSION['matricula']) {
  if (($estado_servico == 2) || ($estado_servico == 4)){
    echo"
    <div class='form-group'>
    <a title='Rejeitar patrimônio'  href='rejeitarPatrimonio.php?o=".$idPatrimonio."'>
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
    echo "<div class='form-group'><label><i class='glyphicon glyphicon-warning-sign'></i> Defeitos encontrados</label><br>";
    $defeitos = $patrimonio->exibirDefeito($idPatrimonio);
    
    foreach ($defeitos as $row){
      $nomeDefeito = $patrimonio->nomeDefeito($row['Defeito_id']);
      foreach ($nomeDefeito as $linha){
        if ($linha['categoria'] == 1){$categoria = "Hardware";}
        else if ($linha['categoria'] == 2){$categoria = "Software";}
        echo $categoria." - ".$linha['detalhe']."<br>";
      }  

    }
    echo "</div>";
    echo "
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
unset($patrimonio);
unset($usuario);
unset($patrimonio);
unset($laboratorio);
unset($LOG);
unset($categoria);
?>
<div class='modal fade' id='modal_excPatrimonioSimples' tabindex='-1' role='dialog' aria-labelledby='modal_excPatrimoniosSimplesLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content panel-danger'>
      <div class='modal-header panel-heading'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='modal_excUsuarioLabel'>O usuário será excluído</h4>
      </div>
      <div class='modal-body'>
        Você realmente deseja excluir patrimônio?
      </div>
      <div class="modal-footer">
        <form id="confirm" method="POST" action="verPatrimonio.php?o=<?php echo $idPatrimonio;?>">
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
 document.forms["patrimonio"].submit();
}
</script>
</div><!-- /#wrapper -->
</body>
</html>