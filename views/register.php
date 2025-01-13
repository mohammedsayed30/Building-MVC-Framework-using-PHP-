
<h2>Register Here</h2>

<!-- this for opening the form -->
<?php $form  = \app\core\form\Form::begin('', "post") ?>
<input type="hidden" name="_method" value="post" />
   <div class="row">
    <!-- this for fristname field -->
    <div class="col">
         <?php echo $form->field($model,'fristname') ?>
    </div>
   <!-- this for lastname field -->
    <div class="col">
        <?php echo $form->field($model,'lastname') ?>
    </div>

   </div>  
        <!-- this for email field -->
        <!-- PHP treats feild $object as a string because echo expects a string as its argument -->
        <?php echo $form->field($model,'email') ?>
        <!-- this for password field -->
        <?php echo $form->field($model,'password')->passwordField() ?>
        <!-- this for confirmPassword field -->
        <?php echo $form->field($model,'confirmPassword')->passwordField() ?>    
        <br>
        <!-- this for sumbit the form -->
       <button type="submit" class="btn btn-primary">Register</button>  
<!-- this for closing the form -->
<?php   \app\core\form\Form::end() ?>

