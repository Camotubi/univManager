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
                                   
                    <a class="navbar-brand">Programas</a>
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
                                <h4 class="title">Agregar Programa</h4>
                            </div>
                                                <form class="plan">
                                                <label>Código de plan</label>
                                                <input type="text" class="form-control" placeholder="Código de plan">
                                                
                                                <label for="exampleInputEmail1">Fecha de aprobación</label>
                                                <input type="date" class="form-control" placeholder="Fecha de aprobación">
              
                                                <label for="exampleInputEmail1">Nombre</label>
                                                <input type="text" class="form-control" placeholder="Nombre">
              
                                                <label for="exampleInputEmail1">Descripción</label>
                                                <input type="text" class="form-control" placeholder="Descripción">
              
                                    <br></br>
                                    <button type="submit" class="btn btn-info btn-fill pull-right Agregar_plan">Agregar</button>
                                    </form>
                            </div>
                        

            </div>  
            
            



       <?php 
  require '../Marco/footer.php';
?>

    </div>
</div>
