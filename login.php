<?php

require_once ("variables.php");
require_once ("strings.php");
require_once ("utils.php");
require_once ("UserClass.php");

// Get the objects used to parse the HTML page and modify it
[$dom, $html_content_xpath] = getHTMLXPATH($login_page);

// First entry
if(!isset($_POST[STR_GET_LOGIN_BTN])){
    // Upload the HTML page - no action needed in the first entry
    echo $dom->saveHTML();
}
// Second entry, after the user completed the fields and pressed the register button
else{
    checkFields($dom, $db);
}

function checkFields($dom, $db){
    // Store FALSE if any of the fields are invalid
    $fieldsAreValid = TRUE;
    // The user filled with a user or an email address - the login can be made by user or email
    $isUser = TRUE;
    // Get the mandatory fields to check the data from database
    $user = isset($_POST[STR_GET_USER]) ? $_POST[STR_GET_USER] : "";
    $password = isset($_POST[STR_GET_PASSWORD])? $_POST[STR_GET_PASSWORD] : "";
    // The mandatory fields are completed - not empty
    if(!empty($user) && !empty($password)){
        // Check if the user wrote a username or an email address
        if(strpos($user, "@") == FALSE){ // Not an email address
            $isUser = TRUE;
            if( !isUserValid($user)){
                $fieldsAreValid = FALSE;
                // Show error message
                appendHTML($dom, STR_USER_BOX, STR_USER_INVALID);
            }
        }
        else{
            $isUser = FALSE;
            if( !isEmailValid($user)){
                $fieldsAreValid = FALSE;
                // Show error message
                appendHTML($dom, STR_USER_BOX, STR_EMAIL_INVALID);
            }
        }
        
        // Get all users from database with the same username/email introduced in the registration field
        $loginCheck = $db->query( "SELECT * FROM users WHERE ".
            ($isUser ? STR_USER_DB : STR_EMAIL_DB)."='{$user}'".
            " AND ".STR_PASSWORD_DB."='{$password}'");

        // Check if received valid result - FALSE means failure
        if($loginCheck == FALSE){
            appendHTML($dom, STR_LOGIN_BOX, STR_DATABASE_ERROR_RECEIVE);
            $fieldsAreValid = FALSE;  
        }
        else{
            // Count the number of users received from database
            $loginUserCount = $loginCheck->fetchColumn();
            // If there are users with the same name in database
            if($loginUserCount > 0){
                echo "FOUND THE USER!";
            }  
            else{
                appendHTML($dom, STR_LOGIN_BOX, 
                            $isUser ? STR_USER_PASSWORD_INVALID : 
                                      STR_EMAIL_PASSWORD_INVALID);
            }
        }
    } 
    // The mandatory fields are not filled - empty
    // Check if the fields are empty. If yes, $fieldsAreValid will keep its value, if not, it will be FALSE
    $fieldsAreValid = checkLoginFieldsForEmpty($dom, $user, $password) ? $fieldsAreValid : FALSE;
    
    if($fieldsAreValid == TRUE){
        loginFromDataBase($db, $loginCheck);
    } else{
        saveHTML($dom);
    }
}

function loginFromDataBase($db, $loginCheck){  
    echo "Login ";
    $user = $loginCheck->fetchObject("UserClass");
    echo $user == FALSE;
    echo " columns - ";
    echo $user->getEmail();
    echo var_dump($loginCheck);
            
        /*if(is_numeric($idCheck)){
            //`idUtilizator`, `user`, `Email`, `NumeComplet`, `Telefon`, `Localitate`, `Adresa`, `Tip`, `Depozit`, `Parola`
            session_start();
            $_SESSION[STR_ID_DB] = intval($idCheck);
            $_SESSION[STR_USER_DB] = $user;
            $_SESSION[STR_EMAIL_DB] = $email;
            global $market_page_server;
            header( "Location: $market_page_server");
        }
        else{
            saveHTML($dom, STR_DATABASE_ERROR_RECEIVE);
        }*/
}

function saveHTML($dom, $error=NULL){
    if($error != NULL)
        appendHTML($dom, STR_LOGIN_BOX, $error);
    echo $dom->saveHTML();
}

?>