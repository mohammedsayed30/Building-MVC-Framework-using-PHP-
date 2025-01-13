
<?php
/** @var $model \app\models\userLogin */
?>
<h2>Login Here</h2>

<!-- this for opening the form -->
<?php $form  = \app\core\form\Form::begin('', "post") ?>
<input type="hidden" name="_method" value="post" />  
        <!-- this for email field -->
        <!-- PHP treats feild $object as a string because echo expects a string as its argument -->
        <?php echo $form->field($model,'email') ?>
        <!-- this for password field -->
        <?php echo $form->field($model,'password')->passwordField() ?>
        <br>
        <!-- this for sumbit the form -->
       <button type="submit" class="btn btn-primary">Login</button>  
<!-- this for closing the form -->
<?php   \app\core\form\Form::end() ?>

