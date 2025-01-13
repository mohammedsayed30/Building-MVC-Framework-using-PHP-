<?php  

namespace app\core;


/**
 * Abstract base class for models.
 *
 * This class provides common functionality for data validation, error handling,
 * and loading data into model properties. It is designed to be extended by
 * specific models (e.g., User, Product) to define their own rules and behaviors.
 *
 * @package app\core
 */ 

abstract class Model {
    //validation Model Constants
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_EMAIL_UNIQUE= 'unique';
    public const RULE_MIN = 'min' ;
    public const RULE_MAX = 'max' ;
    public const RULE_MATCH = 'match' ;
    //login
    public const RULE_EMAIL_EXISTS= 'email_exists' ;
    public const RULE_PASSWORD_MATCH= 'password_match' ;

    /**
     * Function Name : loadData
     * Load data that got for registeration form  for this object of User 
     */
    public function loadData($data)
    {
        foreach($data as $key => $value){
            //assign the input data from user
            /*this condition to ensure that the User  contain this propert $keyv*/
            if(property_exists($this,$key)){
                /**
                 * {}  They allow you to dynamically access object properties 
                 * where the name of the property is stored in a variable
                 */
                $this->{$key} = $value;
            }
          
        }
    }
   /*must be implements by user models that extend the Model class*/
    abstract public function rules():array;
   //holds all errors that comes from user inputs
    public array $errors=[];
    /*validate the user inputs according the other  registeration model rules that extend from this class*/  
    public function validate()
    {
        $emailValue ='';
       /*extract the rules as the attribute field(eg. fristname) and the rules*/
        foreach($this->rules() as $attribute => $rules){
            /*
            * get the value of the (property-->that stored on the $attribute)
            * $this->{$attribute} === $this->firstname || $this->email and so on 
            */ 
            $value = $this->{$attribute};
            //save the email
            /*extract the rules to get one rule each iterator*/
            foreach($rules as $rule){
                /*hold the rule name*/
                $ruleName = $rule;
                if(!is_string($ruleName )){
                    /*if the rule is an array this mean key value*/
                    $ruleName =  $rule[0];
                }
                
                /**this for save the email login value for password check */
                if($ruleName === self::RULE_EMAIL_EXISTS && $value){
                    $emailValue = $value;
                }

                /*if the field is required and the user did not enter any data */
                if($ruleName === self::RULE_REQUIRED && !$value){
                    /*add the error if this condition become true*/
                    $this->addError($attribute,$ruleName);
                }
                /*if the field is valid email and the user enter not valid email */
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                   /*add the error if this condition become true*/
                    $this->addError($attribute,$ruleName);
                }
                /*if the field is password and the user enter no of chars < min=8 */
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){ 
                     /*add the error if this condition become true*/
                    $this->addError($attribute,$ruleName,$rule);
                }
                 /*if the field is password and the user enter no of chars > min=24 */
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    /*add the error if this condition become true*/
                    $this->addError($attribute,$ruleName,$rule);
                }
                 /*if the field is confirmPassword and the user enter different  password */
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                     /*add the error if two password fields not the same*/
                    $this->addError($attribute,$ruleName,$rule);
                } 
                if($ruleName === self::RULE_EMAIL_UNIQUE && !($this->isEmailUnique($value))){
                     /*add the error if this input email already exist in the database*/
                    $this->addError($attribute,$ruleName);
                }
                //check if the email regitered for login
                if($ruleName === self::RULE_EMAIL_EXISTS && !($this->isEmailExists($value))){
                    /*add the error if this input email not regiter*/
                   $this->addError($attribute,$ruleName);
               }
               if($ruleName === self::RULE_PASSWORD_MATCH && !($this->isCorrectPassword($emailValue,$value)) ){
                /*add the error if this input email already exist in the database*/
               $this->addError($attribute,$ruleName);
               }
            }
        }
        //return true if the user's data pass all User rules
        return empty($this->errors);
    }
    /*add the corrospond errors fo each field*/
    public function addError(string $attribute, string $rule, $params=[])
    {
        //params : [self::RULE_MIN,'min'=>8]
        //get the error message of  the corrospond  rule
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value){
            $message=str_replace("{{$key}}",$value,$message);
        }
        /*append the errors for the corrospond attribute*/
        $this->errors[$attribute][]= $message;
    }

    public function labels() : array {
        return [];
    }

    public function  getLabel($attribute){
        return $this->labels()[$attribute] ?? $attribute;
    }
    //the Error messages for the corrosponds rules
    public function errorMessages()
    {
       return[
        self::RULE_REQUIRED =>'this is required you must enter the value',
        self::RULE_EMAIL_UNIQUE =>'this email  already registered',
        self::RULE_EMAIL =>'this input must be valid emil address',
        self::RULE_MIN =>'this passorwd must be at least {min} chars',
        self::RULE_MAX =>'this is required must not large than {max} chars',
        self::RULE_MATCH =>'this is required must be the same as {match}',
        self::RULE_EMAIL_EXISTS =>'this email not registered',
        self::RULE_PASSWORD_MATCH =>'this password not correct',
       ];
    }
   
    /*to check if  an  attribute has errors or not */
    public function hasError($attribute){
        //return true or false
        return $this->errors[$attribute] ?? false;
    }
   /*to get only the frist error if each an attribute*/
    public function getFirstError($attribute){
        //return the  frist attribute
        return $this->errors[$attribute][0] ?? false;
    }

}