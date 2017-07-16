<div class="wrapper">
    <?php 
  require '../Marco/header.php';
?>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed" >
            <div class="container-fluid">
                <div class="navbar-header">
                    
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                                   
                    <a class="navbar-brand">Asignaturas</a>
                </div>
                <div class="collapse navbar-collapse">
                    

                    <ul class="nav navbar-nav navbar-right">
                        
                        <li>
                            <a class="log_out" href="#">
                                <p>Cerrar Sesión</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            
          <div class="container-fluid">
                            <div class="header">
                                <h4 class="title">Agregar Asignatura</h4>
                            </div>
                                                 <form class="Asignatura">
                                                <label>Código de asignatura</label>
                                                <input type="text" class="form-control cod_plan" placeholder="Código de asignatura">
                                         
                                                <label>Créditos</label>
                                                <input type="text" class="form-control fecha_aprob" placeholder="Créditos">
              
                                                <label>Nombre</label>
                                                <input type="text" class="form-control nombre_plan" placeholder="Nombre">
              <!-- Aqui hay que poner automaticamente los que se pusieron en planes -->
                                                <label>Programa</label>
               <select class="form-control nombre_plan" name="Nombre de plan de estudio">
                   
  </select>
              
                                    <br></br>
                                    <button type="submit" class="btn btn-info btn-fill pull-right Agregar_asig" value="Submit">Agregar</button>
                                    <div class="clearfix"></div>
               </form>
                            </div>
                        

            </div>  
            
            



       <?php 
  require '../Marco/footer.php';
?>

    </div>
</div>
