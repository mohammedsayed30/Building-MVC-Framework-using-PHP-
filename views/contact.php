
<h2>Contact With Us</h2>

<!-- this for opening the form -->
<?php $form  = \app\core\form\Form::begin('', "post") ?>
<input type="hidden" name="_method" value="post" />
 
        <!-- this for email field -->
        <!-- PHP treats feild $object as a string because echo expects a string as its argument -->
        <?php echo $form->field($model,'subject') ?>     
        
        <!-- this for email field -->
        <!-- PHP treats feild $object as a string because echo expects a string as its argument -->
        <?php echo $form->field($model,'email') ?>
        
        <!-- this for password field -->
        <?php echo $form->field($model,'body')->textareaField() ?>   
        <br>
       
        <!-- this for sumbit the form -->
       <button type="submit" class="btn btn-primary">Send</button>  
<!-- this for closing the form -->
<?php   \app\core\form\Form::end() ?>

