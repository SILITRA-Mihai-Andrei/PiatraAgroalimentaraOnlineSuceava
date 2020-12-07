<?php

require_once ('strings.php');

/***
 * @param $page: The HTML file.
 * @return: Return the DOMDocument object and a DOMXPath object using an HTML file.
 */
function getHTMLXPATH($page){
    // Create a DOMDocument object for parsing the html page
    $dom = new DOMDocument();
    // Load the HTML file
    $dom->loadHTMLFile($page);
    // Evaluate Anchor tag in HTML and return the objects
    return [$dom, new DOMXPath($dom)];
}

/***
 * Create HTML element to append to another HTML element.
 * @param $domObj: The DOMDocument with the HTML file loaded.
 * @param $tag_name: The parent tag of the element that will be appended.
 * @param $value: The content inside the tag parent.
 * @param $attributes: The array of attributes for the parent tag.
 * @return: The HTML element ready to be appended to another HTML element.
 */
function createElement($domObj, $tag_name, $value=NULL, $attributes=NULL)
{
    // Creathe the parent HTML element with its content
    $element = ($value != NULL ) ? $domObj->createElement($tag_name, $value) : $domObj->createElement($tag_name);
    // Adding the attributes
    if( $attributes != NULL )
    {
        // For each attribute in the array
        foreach ($attributes as $attr=>$val)
        {
            // Add the attribute to the parent HTML element
            $element->setAttribute($attr, $val);
        }
    }
    // Return the created HTML element
    return $element;
}

/***
 * Add an HTML element to another HTML element.
 * @param $dom: The DOMDocument with the HTML file loaded.
 * @param $id: The HTML element id after which to appent the new HTML element.
 * @param $textToAdd: The content inside the tag parent.
 * @param $tag: The parent tag of the element that will be appended.
 * @param $array_of_attributes: The array of attributes for the parent tag.
 * @return: Nothing.
 */
function appendHTML($dom, $id, $textToAdd, $tag = "div", $array_of_attributes=NULL) {
    // If the function is called without attributes array parameter
    if ($array_of_attributes == NULL){
        // Make the $invalid_field_array_of_attributes variable global
        global $invalid_field_array_of_attributes;
        // Set the default attributes array (for invalid fields - ex: login/register page)
        $array_of_attributes = $invalid_field_array_of_attributes;
    }
    // Get the element you want to append to
    $descBox = $dom->getElementById($id);
    // Create the element to append to #element1
    $appended = createElement($dom, $tag, $textToAdd, $array_of_attributes);
    // Append the element
    $descBox->appendChild($appended);
}

function checkRegisterFieldsForInvalid($dom, $user, $email, $mobile){
    $valid = TRUE;
    if(!isUserValid($user)){
        // Show error message
        appendHTML($dom, STR_USER_BOX, STR_USER_INVALID);
        $valid = FALSE;
    }
    if(!isEmailValid($email)){
        // Show error message
        appendHTML($dom, STR_EMAIL_BOX, STR_EMAIL_INVALID);
        $valid = FALSE;
    }
    if(strlen($mobile) != 0 and (!preg_match("/^[0-9']*$/", $mobile) or strlen($mobile) != 10)){
        // Show error message
        appendHTML($dom, STR_MOBILE_BOX, STR_MOBILE_INVALID);
        $valid = FALSE;
    }
    return $valid;
}

function checkRegisterFieldsForEmpty($dom, $name, $user, $email, $password){
    $valid = TRUE;
    if(empty($name)){
        appendHTML($dom, STR_NAME_BOX, STR_NAME_EMPTY);
        $valid = FALSE;
    }
    if(empty($user)){
        appendHTML($dom, STR_USER_BOX, STR_USER_EMPTY);
        $valid = FALSE;
    }
    if(empty($email)){
        appendHTML($dom, STR_EMAIL_BOX, STR_EMAIL_EMPTY);
        $valid = FALSE;
    }
    if(empty($password)){
        appendHTML($dom, STR_PASSWORD_BOX, STR_PASSWORD_EMPTY);
        $valid = FALSE;
    }
    return $valid;
}

function checkLoginFieldsForEmpty($dom, $user, $password){
    $valid = TRUE;
    if(empty($user)){
        appendHTML($dom, STR_USER_BOX, STR_USER_EMPTY);
        $valid = FALSE;
    }
    if(empty($password)){
        appendHTML($dom, STR_PASSWORD_BOX, STR_PASSWORD_EMPTY);
        $valid = FALSE;
    }
    return $valid;
}

function isEmailValid($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isUserValid($user){
    return preg_match("/^[a-zA-Z0-9-' ]*$/", $user);
}
