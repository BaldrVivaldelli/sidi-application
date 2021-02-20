<?php $__env->startSection('content'); ?>
<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <div id="main">
        <div class="inner">

            <!-- Header -->
            <header id="header">
                <a href="index.html" class="logo"><strong>Home</strong></a>

            </header>

            <!-- Banner -->


            <!-- Section -->


            <!-- Section -->
            <section>
                <header class="major">
                    <h2>Contenidos</h2>
                </header>
                <div class="posts">
                    <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article> 
                        <!-- <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a> -->
                        <?php if($region['region_size'] == "1"): ?>
                            <a href="#" class="image"><img class="imgTemp" src="\images\1Pantallas.png"></a>                            
                        <?php endif; ?>
                        <?php if($region['region_size'] == "3"): ?>
                            <a href="#" class="image"><img class="imgTemp" src="\images\3Pantallas.png"></a>                 
                        <?php endif; ?>
                        <?php if($region['region_size'] == "4"): ?>                               
                        <a href="#" class="image"><img class="imgTemp" src="\images\4Pantallas.png"></a>                 
                        <?php endif; ?>
                        
                        
                        <h3>Nombre <?php echo e($region['name']); ?></h3>
                        <h3>Cant de dispositivos: <?php echo e($region['cant_disp']); ?></h3>
                        <h3>Estado: <?php echo e($region['estado']); ?></h3>
                        <?php if(Auth::user()->id_estado != 2): ?>
                            <ul class="actions">
                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('detail-post-<?php echo e($region['name']); ?>').submit();" class='button'>
                                        Detalle
                                    </a>
                                </li>
                                <form id="detail-post-<?php echo e($region['name']); ?>" action="/content/getById/<?php echo e($region['name']); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                    <input name="_method" type="hidden" value="POST">
                                </form>
                            </ul>
                            <ul class="actions">
                                <!-- <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete-post-<?php echo e($region['name']); ?>').submit();" class='button'>
                                        Borrar
                                    </a>
                                </li>
                                <form id="delete-post-<?php echo e($region['name']); ?>" action="/content/delete/<?php echo e($region['name']); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                    <input name="_method" type="hidden" value="POST">
                                </form> -->
                            </ul>
                        <?php endif; ?>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </section>

        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Menu</h2>
                </header>
                <ul>
                    <li><a href="/home">Inicio</a></li>

                    <?php if(Auth::user()->id_estado != 2): ?>

                        <?php if(Auth::user()->id_rol == 2): ?>
                        <li><a href="/users">Administracion de Usuarios</a></li>
                        <li><a href="/logs">Ver Logs</a></li>
                        <?php endif; ?>

                        <li><a href="/profile">Perfil</a></li>
                        <li>
                            <span class="opener">Contenidos</span>
                            <ul>
                                <li><a href="/content/create">Agregar Contenido</a></li>
                                <li><a href="/content/delete">Borrar Contenido</a></li>
                                <li><a href="/content/modify">Modificar Contenido</a></li>

                            </ul>
                        </li>
                        <li>
                            <span class="opener">Dispositivos</span>
                            <ul>
                                <li><a href="/display/getAll">Administrar Dispositivos</a></li>                            
                            </ul>
                        </li>
                    <?php else: ?>
                    <li><a href="/profile">Perfil</a></li>
                    <?php endif; ?>
                    <li><a href="/logout">Salir</a></li>

                </ul>
            </nav>

        </div>
    </div>
</div>

<?php if($messageType != 'new'): ?>
<script>

    
    // const ws = new WebSocket('ws://192.168.1.100:8090');                 
    const ws = new WebSocket('ws://<?php echo e(config('app.socket_url')); ?>'); 
    ws.onopen = function(e) {
        console.log('Connected a sidi');
        onOpen(e);
        function success(position) {
            console.log('me conecte mando una actualizacion');

            <?php if($messageType == 'modificacion'): ?>
            ws.send(
                JSON.stringify({
                    'type': 'incremental',
                    'region_id': "<?php echo e($region_id); ?>"
                }));
            <?php endif; ?>
        }

    }

    function error() {
        status.textContent = 'Unable to retrieve your location';
    }

    var isDataSend = false;


    function onOpen(e) {

        if (!isDataSend) {
            <?php if($messageType == 'saveNewDisplay'): ?>
            console.log('llego algo, agrego un nuevo dispositivo');
            ws.send(JSON.stringify({
                'type': 'saveNewDisplay',
                'ip': "<?php echo e($data); ?>"
            }));
            <?php endif; ?>

            <?php if($messageType == 'updateDisplay'): ?>
            console.log('llego algo, se modifico un nuevo dispositivo');
            ws.send(JSON.stringify({
                'type': 'updateDisplay',
                'ip': "<?php echo e($data); ?>"
            }));
            <?php endif; ?>

            <?php if($messageType == 'modificacion'): ?>
            console.log('llego algo, mando una modificacion');
            console.log('<?php echo e($region_id); ?>');
            if (!isDataSend) {
                ws.send(
                    JSON.stringify({
                        'type': 'incremental',
                        'region_id': "<?php echo e($region_id); ?>",
                        'state': "new"

                    }));
            }
            <?php endif; ?>
        }
        isDataSend = true;

    }
</script>
<?php endif; ?>



<style>
.space {
    width:100%;
}
.separate-v{
    float:left;
    width:2%;
    height:1000px;
}
.separate-h{
    float:left;
    height:5px;
    width:30%;
}

.large {
    width:60%;
    float:left;
    padding:0px;
}
.small {
    width:30%;
    float:left;
    padding:0px;
}
.medium {
    width:50%;
    float:left;
    padding:0px;
}
img {
    width:100%;
    height:auto;
    vertical-align:bottom;
    padding:0px;
    margin:0px;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>