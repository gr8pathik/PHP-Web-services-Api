<?php
//https://github.com/indieteq/PHP-MySQL-PDO-Database-Class
require('dbClass.php');
/*In order to retrieve a comment , the comment must be immediately before the class, function or method, start with /** and end with */

/** 
* A test class
*
* @param -> foo bar
* @return -> baz
*/
class Services {
	private $objDb;	//this is the declaration of database object variable
  public $params = array();

  function __construct()
  {
    //Create the database object
    $this->objDb = new Db();
  }

  /**
	 * Retrieve metadata function class from a file.
	 * @@label : User Login
   * @@desc  : Login for user
   * @@requestVar : email->['pass'->'pathikgandhi@indianic.com','sada'->'asdasd']
	 * @@requestVar : email->pathikgandhi@indianic.com
	 * @@requestVar : password->123456
	 */
  	function loginUser($returnData = array()){
      $lu_uEmail = addslashes($returnData['email']);
      $lu_uPassword = md5($returnData['password']);
      
      $sql_1 = 'select * from `users` where email = "'.$lu_uEmail.'" and
      password = "'.$lu_uPassword.'" ';
    
      $temp = $this->objDb->query($sql_1);
      if(!empty($temp)){
        $final['result'] = 1;
        $final['uId'] = $temp[0]['id'];
        $final['uName'] = stripslashes($temp[0]['name']);
        $final['uEmail'] = stripslashes($temp[0]['email']);
      }else{
        $final['result'] = 0;
        $final['message'] = 'Email and Password does not match. Try again.';
      }
      
      return $final;
    }

    /**
   * Retrieve metadata function class from a file.
   * @label : Register
   * @desc  : Registration for user
   * @requestVar : email->pathikgandhi@indianic.com
   * @requestVar : password->123456
   */
    function registerUser(){
      
      $ru_uName     = addslashes($this->params['name']);
      $ru_uPassword = md5($this->params['password']);
      $ru_uEmail    = addslashes($this->params['email']);
      $ru_uGender   = addslashes($this->params['gender']);
      $ru_uPhone    = addslashes($this->params['phone']);
      $ru_uPublished  = addslashes($this->params['published']);
          
      $temp2 = false;
      
      if($temp2 > 0){
        $final['result'] = 0;
        $final['message'] = 'It appear that your email address has already been registered.';
        return $final;
      }
       
       $sql = 'INSERT INTO `user` (`name`, `password`, `email`, `gender`, `phone`, `published` ) VALUES ("'.$ru_uName.'","'.$ru_uPassword.'", "'.$ru_uEmail.'", "'.$ru_uGender.'", "'.$ru_uPhone.'", "'.$ru_uPublished.'")';
      
      //Call to DbClass insert method
      $uId  = $this->objDb->insert($sql);
      
      if($uId){
        $final['result'] = 1;
        $final['uId'] = $uId;
        $final['message'] = 'User Registered Successfully';
      }else{
        $final['result'] = 0;
        $final['message'] = 'Some problem to register this user';
      }
      
      return $final;
    }
}

function getComment($commentPArt = ''){
      $commentPArt = preg_replace('/\*+/','',$commentPArt); //Remove *
      $commentPArt = preg_replace('{/}','',$commentPArt); //Remove Forward comment_sections
      $comment_sections = explode("@@", $commentPArt);
      $delimeter = ":";
      $delimeterParam = "->";
      $listHeaders = array();
      $extraHeaders = array();
      foreach ($comment_sections as $value) {
        $value = trim($value);
        if(strpos($value, $delimeter) === false){
          $extraHeaders[] = $value;
        }else{
          $breakVal = explode($delimeter, $value);
          print_r($breakVal);
          echo strpos($breakVal[1], '[');
          if(trim($breakVal[0]) == 'requestVar'){
            if(strpos($breakVal[1], '[') == 0){
              print_r($breakVal);
              exit;
            } else if(strpos($breakVal[1], $delimeterParam) === false){
              $listHeaders[trim($breakVal[0])][] = trim($breakVal[1]);  
            }else{
              $breakValParam = explode($delimeterParam, $breakVal[1]);
              $listHeaders[trim($breakVal[0])][trim($breakValParam[0])] = trim($breakValParam[1]);  
            }            
          }else{
            $listHeaders[trim($breakVal[0])] = trim($breakVal[1]);
          }
        }
      }
      return $listHeaders;
}

/**
 * Show the data in given format
 *
 * @param array $data
 * @param type $type
 */
function showData($data,$type = 'json')
{
  if($type == 'json')
  {
    //print the data in json format
    echo json_encode($data);
  }
  else
  {
    //print the data in array format
    print_r($data); 
  }     
}