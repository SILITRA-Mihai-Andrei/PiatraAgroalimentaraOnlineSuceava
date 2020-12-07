<?php

require_once ("variables.php");
require_once ("strings.php");
require_once ("utils.php");

// Get the objects used to parse the HTML page and modify it
[$dom, $html_content_xpath] = getHTMLXPATH($register_page);

// First entry
if(!isset($_GET[STR_GET_REGISTER_BTN])){
    // Upload the HTML page - no action needed in the first entry
    echo $dom->saveHTML();
}
// Second entry, after the user completed the fields and pressed the register button
else{
    checkFields($db);
}

function checkFields($db){
    global $dom;
    $fieldsAreValid = TRUE;
    // Get the mandatory fields to check the data from database
    $user = isset($_GET[STR_GET_USER]) ? $_GET[STR_GET_USER] : "";
    $email = isset($_GET[STR_GET_EMAIL]) ? $_GET[STR_GET_EMAIL] : "";
    $name = isset($_GET[STR_GET_NAME]) ? $_GET[STR_GET_NAME] : "";
    $password = isset($_GET[STR_GET_PASSWORD])? $_GET[STR_GET_PASSWORD] : "";
    // Get the rest of the fields
    $mobile = isset($_GET[STR_GET_MOBILE]) ? $_GET[STR_GET_MOBILE] : NULL;
    $locality = isset($_GET[STR_GET_LOCALITY]) ? $_GET[STR_GET_LOCALITY] : NULL;
    $address = isset($_GET[STR_GET_ADDRESS]) ? $_GET[STR_GET_ADDRESS] : NULL;
    $index = isset($_GET[STR_GET_REGISTER]) ? $_GET[STR_GET_REGISTER] : 1;
    $deposit = isset($_GET[STR_GET_DEPOSIT]) ? $_GET[STR_GET_DEPOSIT] : NULL;
    // The mandatory fields are completed - not empty
    if(!empty($name) && !empty($user) && !empty($email) && !empty($password)){
        // Get all users from database with the same name introduced in the registration field
        $numeCheck = $db->query( "SELECT ".STR_USER_DB." FROM users WHERE ".STR_USER_DB."='{$user}'");
        // Get all email addresses from database with the same email introduced in the registration field
        $emailCheck = $db->query( "SELECT ".STR_EMAIL_DB." FROM users WHERE ".STR_EMAIL_DB." = '{$email}'");

        // Check if received valid result - FALSE means failure
        if($numeCheck == FALSE or $emailCheck == FALSE){
            appendHTML(STR_REGISTER_BOX, STR_DATABASE_ERROR_RECEIVE);
            $fieldsAreValid = FALSE;  
        }
        else{
            // Count the number of users received from database
            $rowUserCount = $numeCheck->fetchColumn();
            // Count the number of email addressed from database
            $rowEmailCount = $emailCheck->fetchColumn();
            // If there are users with the same name in database
            if($rowUserCount > 0){
                // Show error message
                appendHTML(STR_NAME_BOX, STR_USER_ALREADY_EXISTS);
                $fieldsAreValid = FALSE;
            }  
            // If there are users with the same email addressed in database
            if($rowEmailCount > 0){
                // Show error message
                appendHTML(STR_EMAIL_BOX, STR_EMAIL_ALREADY_EXISTS);
                $fieldsAreValid = FALSE;
            }
        }
        // Check if the fields are valid. If yes, $fieldsAreValid will keep its value, if not, it will be FALSE
        $fieldsAreValid = checkRegisterFieldsForInvalid($dom, $user, $email, $mobile) ? $fieldsAreValid : FALSE;
    } 
    // The mandatory fields are not filled - empty
    else {
        // Check if the fields are empty. If yes, $fieldsAreValid will keep its value, if not, it will be FALSE
        $fieldsAreValid = checkRegisterFieldsForEmpty($dom, $name, $user, $email, $password) ? $fieldsAreValid : FALSE;
    }
    
    if($fieldsAreValid == TRUE){
        registerUserToDataBase($db, $user, $email, $name, $mobile, $locality, $address, $index, $deposit, $password);
    } else{
        saveHTML();
    }
}

function registerUserToDataBase($db, $user, $email, $name, $mobile, $locality, $address, $index, $deposit, $password){
    global $login_page_server;
    $index_DB = $index - 1;
    $createCheck = $db->query( "INSERT INTO users
                VALUES (NULL, '{$user}', '{$email}', '{$name}', '{$mobile}'
                , '{$locality}', '{$address}', {$index_DB}, NULL, '{$password}')");
    if($createCheck == FALSE){
        saveHTML(STR_DATABASE_ERROR_RECEIVE);
    }
    else{
        $idCheck = $db->query( "SELECT ".STR_ID_DB." FROM users WHERE "."user"."='{$user}'");
        $idCheck = $idCheck->fetchColumn();            
        if(is_numeric($idCheck)){
            header( "Location: $login_page_server");
        }
        else{
            saveHTML(STR_DATABASE_ERROR_RECEIVE);
        }
    }
}

function saveHTML($error=NULL){
    global $dom;
    if($error != NULL)
        appendHTML($dom, STR_REGISTER_BOX, $error);
    echo $dom->saveHTML();
}

?>