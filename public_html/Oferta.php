    <?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../resources/config.php';
require RESOURCES_PATH.'/Estudiante.php';
require RESOURCES_PATH.'/Programa.php';
require RESOURCES_PATH.'/security.php';
?>

<!doctype html>
<html>
<?php require TEMPLATES_PATH.'/head.php';?>
<body>
<?php
    require TEMPLATES_PATH.'/sidebar.php';
?>
<div class="main-panel">

<?php
    $navbarBrand = "Menu Principal";
    require TEMPLATES_PATH.'/navbar.php';
?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    
                    <a href="#"> 
                    <div class="col-md-6">
                        <div class="card" style="background-image: url(assets/img/generarOA.jpg); background-position: center; ">
                            <div class="header">
                                
                            </div>
                            
                            
                            <div class="content">
                                
                                
                                
                            </div>
                        </div>
                    </div>
                    </a>
                    
                    <a href="#"> 
                    <div class="col-md-6">
                        <div class="card" style="background-image: url(assets/img/generarHD.jpg); background-position: center; ">
                            
                        </div>
                    </div>
                    </a>
                    
                    
                </div>
                
                <div class="row">
                    
                    <a href="#"> 
                    <div class="col-md-6">
                        <div class="card" style="background-image: url(assets/img/generarHM.jpg); background-position: center; ">
                            
                        </div>
                    </div>
                    </a>
                    
                    
                </div>

            </div>
        </div>


<?php require TEMPLATES_PATH.'/footer.php'; ?>  

    </div>
    </body>
    </html>

