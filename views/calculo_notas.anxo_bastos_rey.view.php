<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo de notas</h1>

</div>
<!-- Content Row -->

<div class="row">
    <?php
    if(isset($data['resultado'])){
    ?>
        <!-- TABLA -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resultados por módulo</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Media</th>
                                <th>Aprobados</th>
                                <th>Suspensos</th>
                                <th>Máximo</th>
                                <th>Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data['resultado'] as $nombreModulo => $datosModulo){
                                if($nombreModulo != 'listaSuspensos'){
                            ?>
                            <tr>
                                <td><?php echo ucfirst($nombreModulo);?></td>
                                <td><?php echo number_format($datosModulo['media'], 2, ',', '.');?></td>
                                <td><?php echo $datosModulo['aprobados']; ?></td>
                                <td><?php echo $datosModulo['suspensos']; ?></td>
                                <td><?php echo $datosModulo['max']['nombre'].': '.number_format($datosModulo['max']['nota'], 2, ',', '.'); ?></td>
                                <td><?php echo $datosModulo['min']['nombre'].': '.number_format($datosModulo['min']['nota'], 2, ',', '.'); ?></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    if(isset($data['resultado'])){
    ?>
    <!-- TARJETAS -->
    <div class="col-12 col-lg-6">
        <div class="alert alert-success">
            <ol>
            <?php 
            foreach($data['resultado']['listaSuspensos'] as $nombre => $suspensas){
                if($suspensas == 0){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="alert alert-warning">
            <ol>
            <?php 
            foreach($data['resultado']['listaSuspensos'] as $nombre => $suspensas){
                if($suspensas >= 1){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="alert alert-primary">
            <ol>
            <?php 
            foreach($data['resultado']['listaSuspensos'] as $nombre => $suspensas){
                if($suspensas <= 1){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="alert alert-danger">
            <ol>
            <?php 
            foreach($data['resultado']['listaSuspensos'] as $nombre => $suspensas){
                if($suspensas >= 2){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <?php
    }
    ?>
    <!-- FORMULARIO -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Array de notas</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=calculo_notas.anxo_bastos_rey">
                    <!--<input type="hidden" name="sec" value="iterativas01" />-->
                    <div class="mb-3">
                        <label for="texto">Json Notas:</label>
                        <textarea class="form-control" id="json_notas" name="json_notas" rows="10"><?php echo isset($data['input']['json_notas']) ? $data['input']['json_notas'] : '';?></textarea>
                        <p class="text-danger small"><?php echo isset($data['errores']['json_notas']) ? $data['errores']['json_notas'] : ''; ?></p>
                    </div>                    
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>