<?php

namespace app\core\form;

use \app\core\Model;

/**
 * Represents a form field, such as an input or textarea.
 *
 * This class is used to generate HTML for form fields and handle validation errors.
 *
 * @package app\core\form
 */

class Field{
    //properties of the Field Objects
    public const TYPE_TEXT= 'text';
    public const TYPE_PASSWORD= 'password';
    public const TYPE_NUMBER= 'number';
    public const TYPE_TEXTAREA= 'textarea';


    public Model $model;
    public string $attribute;
    public string $type;

    
    /**
     * Field constructor.
     *
     * @param Model $model The model instance.
     * @param string $attribute The attribute name of the model.
     */
    
    public function __construct(Model $model,string $attribute){
        //define the type of the input field
        $this->type = self::TYPE_TEXT;
        //assign the model 
        $this->model = $model;
        //assign the attribute name
        $this->attribute= $attribute;
    }

     /**
     * Converts the field object to its HTML representation.
     *
     * This method is automatically called when the object is treated as a string.
     *
     * @return string The HTML for the form field.
     */

    public function __toString()
    {
        //this if the input type is textarea 
        if($this->type ===self::TYPE_TEXTAREA){
            return sprintf('
            <div class="form-group">
                <label>%s</label>
               <textarea name="%s"  class="form-control  %s">%s</textarea>
                <div class="invalid-feedback">
                   %s
                </div>
            </div>',
            $this->model->getLabel($this->attribute),
            $this->attribute,
            /*if the feild has any error display error messages using is-invalid  */
            $this->model->hasError($this->attribute) ?  ' is-invalid'  :  '',
            /*this to get the old value that user entered for each attribute (frist-time='')*/
            $this->model->{$this->attribute},
            /*to display only the first error for each attribute*/
            $this->model->getFirstError($this->attribute)
          );
        }
        //this if the input field is input
        return sprintf('
                <div class="form-group">
                    <label>%s</label>
                    <input type="%s" name="%s" value="%s" class="form-control  %s">
                    <div class="invalid-feedback">
                       %s
                    </div>
                </div>',
        $this->model->getLabel($this->attribute),
        $this->type,
        $this->attribute,
        /*this to get the old value that user entered for each attribute (frist-time='')*/
        $this->model->{$this->attribute},
        /*if the feild has any error display error messages using is-invalid  */
        $this->model->hasError($this->attribute) ?  ' is-invalid'  :  '',
        /*to display only the first error for each attribute*/
        $this->model->getFirstError($this->attribute)
    );
    
    }

    /**
     * Sets the field type to "textarea".
     *
     * @return $this Returns the current instance for method chaining.
     */

    public function textareaField()
    {
        $this->type=self::TYPE_TEXTAREA;
        /*
        * return $this to used after echo and in this case the object field will
        *  treated as string and due this __toString will called
        */
        return $this;
    } 

    /**
     * Sets the field type to "password".
     *
     * @return $this Returns the current instance for method chaining.
     */

    public function passwordField()
    {
        $this->type=self::TYPE_PASSWORD;
        /*
        * return $this to used after echo and in this case the object field will
        *  treated as string and due this __toString will called
        */
        return $this;
    } 
    
}