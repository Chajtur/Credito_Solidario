<?php
 
$fileList = glob('../../Recursos/Carteras/*.xlsx');
usort($fileList, function($a, $b) {
    return filemtime($a) < filemtime($b);
});?>
<div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 l8">
                            <div id="work-collections" class="">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <!--<h4 class="header">Lista de usuarios registrados</h4>-->
                                        <ul id="projects-collection" class="collection" style="border: 1px solid #e0e0e0;">
                                            <li class="collection-item avatar">
                                                <i class="material-icons circle light-blue ">list</i>
                                                <span class="collection-header">Listado por Carteras</span>
                                                <p>Carteras diarias para descarga</p>
                                                
                                            </li>
                                            <li class="collection-item">
                                                <div class="row">
                                                    <div class="col s4 m2 l2">
                                                        <p class="collections-title">No</p>
                                                    </div>
                                                    <div class="col s8 m3 l6">
                                                        <p class="collections-title">Nombre</p>
                                                    </div>
                                                    <div class="col s5 m3 l4 hide-on-small-only">
                                                        <p class="collections-title">Fecha</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $i=0;?>
                                            <?php if(count($fileList) > 0):?>
                                                <?php foreach($fileList as $filename):?>
                                                    <?php $i++;?>
                                                        
                                                        <li class="collection-item">
                                                            <div class="row">
                                                                <div class="col s4 m2 l2 light">
                                                                    <p class="collections-content"><?php echo $i ?></p>
                                                                </div>
                                                                <?php $path_parts = pathinfo($filename);?>
                                                                <div class="col s3 m3 l6 light">
                                                                    <p class="collections-content">
                                                                        <a href=" <?php echo $filename ?>">
                                                                            <?php echo $path_parts['filename'];?>
                                                                        </a>
                                                                    </p>
                                                                </div>
                                                                <div class="col s5 m3 l4 hide-on-small-only">
                                                                    <p class="collections-content"><?php echo date('F d Y, H:i:s', filemtime($filename)); ?></p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <li class="center">
                                                    <h5>No hay ningún archivos</h5></li>
                                            <?php endif;?>
                                            <!--<li class="collection-item">
                                                <div class="row">
                                                    <div class="col s3 hide-on-small-only light">
                                                        <p class="collections-content">Atlantida</p>
                                                    </div>
                                                    <div class="col s8 m3 l2 light">
                                                        <p class="collections-content">31</p>
                                                    </div>
                                                    <div class="col s3 hide-on-small-only light">
                                                        <p class="collections-content">10,000</p>
                                                    </div>
                                                    <div class="col s2 hide-on-small-only light">
                                                        <p class="collections-content">45,000.00</p>
                                                    </div>
                                                    <div class="col s2 hide-on-small-only light">
                                                        <p class="collections-content">#######</p>
                                                    </div>
                                                </div>
                                            </li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <canvas id="myChartBar" width="100" height="110"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>