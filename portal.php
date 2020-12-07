<?php

include ("variables.php");

[$dom, $html_content_xpath] = getHTMLXPATH($portal_page);
// Get all the button from HTML page
$buttons = $html_content_xpath->evaluate("/html/body//button");

for ($i = 0; $i < $buttons->length; $i++) {
        $btn = $buttons->item($i);
        $btn->setAttribute("style", "background-color: blue;");
}

if (isset($_GET['vinde'])) {
    if($_GET['vinde'] == true){
        if(isset($_SESSION['user'])){
            header( "Location: $market_page_server");
        }
        else{
            header( "Location: $login_page_server");
        }
    }   
  }
else if (isset($_GET['cumpara'])){
    if($_GET['cumpara'] == true){
        header( "Location: $market_page_server");
    }
}

// Update the HTML page to the new one
echo $dom->saveHTML();
?>