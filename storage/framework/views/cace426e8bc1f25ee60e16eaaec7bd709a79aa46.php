<?php $__env->startSection('content'); ?>

<!-- Wrapper -->
<div id="wrapper">

  <!-- Main -->
  <div id="main">

    <div class="inner">
      <div id="formlog">
        <h2>Bienvenido a SIDI</h2>
        <?php if($errors->any()): ?>
            <h4><?php echo e($errors->first()); ?></h4>
        <?php endif; ?>

        <form id="loginForm" class="login-form" role=" form" method="POST" action="<?php echo e(url('/login')); ?>">
          <?php echo e(csrf_field()); ?>

          <div class="form">
            <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
            <?php if($errors->has('email')): ?>
            <span class="help-block">
              <strong><?php echo e($errors->first('email')); ?></strong>
            </span>
            <?php endif; ?>

            <input type="password" class="form-control" name="password">
            <?php if($errors->has('password')): ?>
            <span class="help-block">
              <strong><?php echo e($errors->first('password')); ?></strong>
            </span>
            <?php endif; ?>
            <!-- <button type="submit" class="btn btn-primary">
              <i class="fa fa-btn fa-sign-in"></i>Login
            </button>

 -->
            <button type="button" name="login" class="submitButton" id="login" value="Login">Login</button>

            <button type="button" class="submitButton btn btn-primary">
            <!-- <a href="<?php echo e(url('/register')); ?>">
            </a> -->
              <i class="fa fa-btn fa-sign-in"></i>Register
            </button>
        </form>        

            <!-- <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="help-block">
              <p class="text-danger"><?php echo e($error); ?></p>
            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
        <h4>Ingresa con una cuenta <a href="<?php echo e(url('/redirect')); ?>">Google</a></h4>        
        <h6 class="message">No recordas tu contraseña? <a href="/forgot">Click aqui</a></h6>
      </div>
    </div>


  </div>
</div>

<!-- Sidebar -->

</div>

<script>
var buttons = document.getElementsByClassName("submitButton");

Array.prototype.forEach.call(buttons, function(button) {
    // Do stuff here
    button.addEventListener('click', function(){
      if(this.name === "login"){
        document.getElementById('loginForm').submit();
      }else{
        location.href ="<?php echo e(url('/register')); ?>";
      }
    });    
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>