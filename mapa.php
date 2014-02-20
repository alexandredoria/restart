  
<?php
error_reporting("E_warning");
 /* session_start();
  if (empty($_SESSION)) {
    header("Location: ../restart");
    exit;
  } else if ($_SESSION['tipo_usuario'] != "1"){
    header("Location: ../restart/painel.php");
    exit;

  }*/
  $pageTitle  = "Mapa";
  
  include 'nucleo/cabecario.php';

  include 'classes/usuario.class.php';
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
          <h1> Mapa do Laboratório 1</h1>
          <ol class="breadcrumb">
            <li><a href="usuarios.php"><i class="glyphicon glyphicon-user"></i> Usuários</a></li>
            <li class="active"><i class="glyphicon glyphicon-plus-sign"></i> Cadastrar usuário</li>
          </ol>
        </div>
        </div><!-- /.row -->
      
     <div class="col-lg-5">
     
      <div class="row">
       <div class="btn-group" data-toggle="buttons">
               
                <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
       </div>
     </div><!-- /.row -->
     
     
     <br>
         <div class="row">
       <div class="btn-group" data-toggle="buttons">
               
                <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
       </div>
     </div><!-- /.row -->
     
     
     </div>
     
      <div class="col-lg-1"> </div>
      
      
      
        <div class="col-lg-5">
           <div class="row">
             <div class="btn-group" data-toggle="buttons">
               
                <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            	<label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            	<label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
            </div>
         </div><!-- /.row -->
     
     
         <br>
         <div class="row">
           <div class="btn-group" data-toggle="buttons">
               
                <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
           		 <label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           
            	<label class="btn btn-default">
                    <img src="pc_red.png" class="img-responsive" alt="Máquina 1">
    				<input type="checkbox">
  				</label>
           </div>
        </div><!-- /.row -->
     
     
     </div>
      
       
       <div class="col-lg-1"> </div>
      
      
      
   
        
        	
  
              <!-- Button trigger modal -->


     <script src="js/inputmask.js"></script>

    </div><!-- /#page-wrapper -->
  </div><!-- /#wrapper -->
  
</body>
</html>