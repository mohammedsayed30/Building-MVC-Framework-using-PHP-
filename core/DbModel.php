<?php  


namespace app\core;

/**
 * Abstract base class for database models.
 *
 * This class provides common functionality for interacting with the database,
 * such as saving records, preparing SQL statements, and hashing passwords.
 *
 * @package app\core
 */

abstract class DbModel extends Model {
     /**
     * Returns the name of the database table associated with this model.
     *
     * @return string The table name.
     */
    abstract public function tableName(): string;

    /**
     * Returns the list of attributes (columns) for this model.
     *
     * @return array An array of attribute names.
     */

    abstract public function attributes(): array;

    /**
     * Saves the current model instance to the database.
     *
     * Inserts a new record into the database table associated with this model.
     *
     * @return bool Returns `true` if the save operation is successful.
     */
    public function save()
    {
        //get the table and columns names
       $tableName = $this->tableName();
       $attributes = $this->attributes();

       /*to make place holders in php so you can this used this approch
       *  to treat the user input as data not code
       */
       $params = array_map(fn($attr) => ":$attr",$attributes);
       
       /*prepare the sql for add user into the databas users table*/
        $SQL = "INSERT INTO $tableName  (".implode(',',$attributes).") VALUES 
        (" .implode(',',$params).")";
      
      //prepare the query because the values got dynamic from user and to treated as data not sql
      
      $statement = self::prepare($SQL);
       //to get the values from users
       foreach ($attributes as $attribute){
        //to replace :fristname with mohamed for example
        //to bound the values of placeholders
        $statement->bindValue(":$attribute",$this->{$attribute});
       }
       
       /*
       * execute the statment with the actual values of a user  *
       * $statement is the object representing the prepared SQL query that 
       * which tells DBMS to which prepared statement to execute and to replace 
       * the placeholders with actual data .
       */
       $statement->execute();

       return true;
    }

     /**
     * Prepares an SQL statement for execution.
     *
     * @param string $sql The SQL query to prepare.
     * @return \PDOStatement The prepared statement.
     */

    public static function prepare($sql)
    {
        //this to used the prepare function in pdo
        return \app\core\Application::$app->db->pdo->prepare($sql);
    }
    
    /**
     * Hashes a password using the bcrypt algorithm.
     *
     * @param string $password The password to hash.
     * @return string The hashed password.
     */
      public function hashPassword(string $password)
    {
        //set the options for the password hash algorithm
        $options=[
            'cost'=>12
        ];
        //use the password hash function with bycrypt algorithm with cost 12
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}