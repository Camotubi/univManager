<div class="wrapper">
    <?php 
  require 'header.php';
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
                <div class="row">
          <a href="Programas/Agregar.php" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Agregar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Modificar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Eliminar</a>
          <a href="#" class="btn btn-info btn-fill pull-left" style="margin-right: 20px">Buscar</a>
                </div>
                <br> </br>
            <!-- Lo siguiente solo es una prueba de como deberia quedar despues de agregar -->
            <div class="row">
                    <div class="col-md-12">
                                <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>Codigo de plan</th>
                                    	<th>Nombre</th>
                                    	<th>Descripción</th>
                                    	<th>Fecha de aprobación</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        	<td>1</td>
                                        	<td>Dakota Rice</td>
                                        	<td>$36,738</td>
                                        	<td>Niger</td>
                                        </tr>
                                        <tr>
                                        	<td>2</td>
                                        	<td>Minerva Hooper</td>
                                        	<td>$23,789</td>
                                        	<td>Curaçao</td>
                                        </tr>
                                        <tr>
                                        	<td>3</td>
                                        	<td>Sage Rodriguez</td>
                                        	<td>$56,142</td>
                                        	<td>Netherlands</td>
                                        </tr>
                                        <tr>
                                        	<td>4</td>
                                        	<td>Philip Chaney</td>
                                        	<td>$38,735</td>
                                        	<td>Korea, South</td>
                                        </tr>
                                        <tr>
                                        	<td>5</td>
                                        	<td>Doris Greene</td>
                                        	<td>$63,542</td>
                                        	<td>Malawi</td>
                                        </tr>
                                        <tr>
                                        	<td>6</td>
                                        	<td>Mason Porter</td>
                                        	<td>$78,615</td>
                                        	<td>Chile</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                    </div>


                </div>
            </div>
        </div>





    </div>
           <?php 
  require 'footer.php';
?>
</div>
</body>
</html>