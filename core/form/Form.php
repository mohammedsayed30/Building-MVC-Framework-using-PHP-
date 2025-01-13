<?php

namespace app\core\form;

use app\core\Model;


/**
 * Represents an HTML form.
 *
 * This class provides methods to generate the opening and closing tags of a form
 * and to create form fields.
 *
 * @package app\core\form
 */

class Form {

    /**
     * Begins the form by outputting the opening `<form>` tag.
     *
     * @param string $action The URL where the form data will be submitted.
     * @param string $method The HTTP method used to submit the form (e.g., "post", "get").
     * @return Form Returns a new instance of the Form class for method chaining.
     */

    public static function begin($action,$method)
    {
        //printing the opening tag with the specified action  & method
        echo sprintf('<form action="%s" method="%s" >', $action,$method);
        //return this object to used to access the field function
        return new Form();
    }
    /**
     * to end the form field '</form>
     */
    public static function end()
    {
        //printing the closing form
        echo '</form>';
    }

     /**
     * Creates a new form field.
     *
     * @param Model $model The model instance associated with the field.
     * @param string $attribute The attribute name of the model.
     * @return Field Returns a new instance of the Field class.
     */
    public  function field(Model $model,string $attribute)
    {
        //return the Field Object
        return new Field($model,$attribute);
    }

}
