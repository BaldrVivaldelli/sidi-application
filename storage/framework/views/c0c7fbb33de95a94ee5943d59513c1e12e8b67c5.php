<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('images/sidi_logo.png')); ?>">
    <title><?php echo e(config('app.name', 'SIDI - Sistema Integral de Informacion')); ?></title>

    <!-- Scripts -->

    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/browser.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/breakpoints.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/main.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/util.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/mostrar.js')); ?>" defer></script>
    <script src="<?php echo e(asset('js/gmaps.js')); ?>" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js" integrity="sha384-vhJnz1OVIdLktyixHY4Uk3OHEwdQqPppqYR8+5mjsauETgLOcEynD9oPHhhz18Nw" crossorigin="anonymous"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBApy66cKD8zUbMDPNmtVhlooeqJMq1img"></script>
    <!-- Styles -->
    <link href="<?php echo e(asset('css/main.css')); ?>" rel="stylesheet">
</head>

<body class="is-preload">
    <?php echo csrf_field(); ?>
    <?php echo $__env->yieldContent('content'); ?>

</body>

</html>

<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('styles'); ?>