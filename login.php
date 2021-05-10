<?php

require_once ("variables.php");
require_once ("strings.php");
require_once ("utils.php");
require_once ("UserClass.php");

try{
    // Get the objects used to parse the HTML page and modify it
    [$dom, $html_content_xpath] = getHTMLXPATH($login_page);

    // User completed the fields and submited
    if(isset($_POST[STR_GET_USER]) or isset($_POST[STR_GET_PASSWORD])){
        checkFields($dom, $db);
    }
    saveHTML($dom);
}
catch(Exception $e){
    header( "Location: $catch_page");
}


function checkFields($dom, $db){
    // Store FALSE if any of the fields are invalid
    $fieldsAreValid = TRUE;
    // The user filled with a user or an email address - the login can be made by user or email
    $isUser = TRUE;
    // Get the mandatory fields to check the data from database
    $user = isset($_POST[STR_GET_USER]) ? $_POST[STR_GET_USER] : "";
    $password = isset($_POST[STR_GET_PASSWORD]) ? $_POST[STR_GET_PASSWORD] : "";

    // The mandatory fields are not filled - empty
    // Check if the fields are empty. If yes, $fieldsAreValid will keep its value, if not, it will be FALSE
    $fieldsAreValid = checkLoginFieldsForEmpty($dom, $user, $password);
    
    // Check if the username or email address is valid
    if(!empty($user)){
        // Check if the user wrote a username or an email address
        if(isEmail($user) == FALSE){ // Not an email address
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
    }

    // The mandatory fields are completed - not empty
    if(!empty($user) && !empty($password)){
        if($fieldsAreValid == TRUE){
            // Get the user object using the database with user and password
            $user = UserClass::loadUserByUserAndPassword($db, $user, $password);
            // Check if received valid result - FALSE means failure
            if($user == FALSE){
                appendHTML($dom, STR_LOGIN_BOX, 
                            $isUser ? STR_USER_PASSWORD_INVALID : 
                                    STR_EMAIL_PASSWORD_INVALID);
            }
            else{
                session_start();
                $_SESSION[STR_SESSION_USER] = $user;
                global $market_page_server;
                header( "Location: $market_page_server");
                return;
            }
        }
    }
}

function saveHTML($dom, $error=NULL){
    if($error != NULL)
        appendHTML($dom, STR_LOGIN_BOX, $error);
    echo $dom->saveHTML();
}

?>