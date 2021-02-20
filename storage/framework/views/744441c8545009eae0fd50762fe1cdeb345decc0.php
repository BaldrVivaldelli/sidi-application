<?php $__env->startSection('content'); ?>
<div class="container">

<div class="inner">
    <div id="formlog">
            <div class="row justify-content-center">                
                <div class="card-header"><?php echo e(__('Register')); ?></div>
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" id="registerForm" action="<?php echo e(route('register')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label text-md-right"><?php echo e(__('Nombre')); ?></label>
                                    <div class="col-8">
                                        <input id="name" type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                                        <?php if($errors->has('name')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lastname" class="col-4 col-form-label text-md-right"><?php echo e(__('Apellido')); ?></label>
                                    <div class="col-8">
                                        <input id="lastname" type="text" class="form-control<?php echo e($errors->has('lastname') ? ' is-invalid' : ''); ?>" name="lastname" value="<?php echo e(old('lastname')); ?>" required autofocus>

                                        <?php if($errors->has('name')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label text-md-right"><?php echo e(__('E-Mail')); ?></label>

                                    <div class="col-8">
                                        <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

                                        <?php if($errors->has('email')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('email')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

                                    <div class="col-8">
                                        <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>

                                        <?php if($errors->has('password')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('password')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-4 col-form-label text-right"><?php echo e(__('Confirm Password')); ?></label>
                                    <div class="col-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group row col-12">
                                    <div class="col-6">
                                        <button name="register" class="btn submitButton btn-primary">
                                            <?php echo e(__('Register')); ?>

                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn submitButton btn-primary">
                                            VOLVER
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row col-12">
                                    <div class="col-12">
                                        <p>
                                            La password tiene que tener el siguiente formato:</br>
                                                Un caracter en minuscula</br>
                                                Un caracter en mayuscula</br>
                                                Un caracter un digito del 0 al 9</br>
                                                Un caracter un caracter especial</br>
                                                Minimo 8 caracteres</br>
                                                Maximo 12 caracteres</br>
                                        </p>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
    </div>
</div>

<script>

var buttons = document.getElementsByClassName("submitButton");
Array.prototype.forEach.call(buttons, function(button) {
    // Do stuff here
    button.addEventListener('click', function(){
      if(this.name === "register"){
        document.getElementById('registerForm').submit();
      }else{
        location.href ="<?php echo e(url('/login')); ?>";
      }
    });    
});

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>