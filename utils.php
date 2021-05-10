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
    //if($descBox == NULL) return;
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

function currentUrl() {
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
    $host     = $_SERVER['HTTP_HOST'];
    $script   = $_SERVER['SCRIPT_NAME'];
    $params   = $_SERVER['QUERY_STRING'];
    return $protocol . '://' . $host . $script . (empty($params) ? "?" : '?'.$params.'&');
}

function isEmail($user){
    return strpos($user, "@");
}

function isEmailValid($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isUserValid($user){
    return preg_match("/^[a-zA-Z0-9-' ]*$/", $user);
}

function isFavoriteProduct($db, $user, $product){
    if($user == NULL or $product == NULL) return false;
    $result = $db->query("SELECT id_product FROM favorites WHERE id_user=".$user->getId()." AND id_product=".$product);
    if($result == FALSE or $result == NULL) return false;
    return $result->rowCount()>0 ? true : false;
}

function getProductImage($db, $product){
    $result = $db->query('SELECT link FROM products_image WHERE id='.$product->getId());
    if($result == FALSE or $result->rowCount()==0){
        return "default.jpg";
    }
    return $result->fetchColumn();
}

function getCard($db, $product, $user){
    $isFavorite = isFavoriteProduct($db, $user, $product->getId());
    return 
        '<div class="col-sm-4">
        <div class="product-card-4 text-center product-card-text">
            <img id="productImage" src="'.STR_PRODUCTS_LINK.
            getProductImage($db, $product).
            '" class="img img-responsive">
            <div class="product-content">
                <a '.($user==NULL ? "" : ('href="'.currentUrl().
                    ($isFavorite ? "removeFavorite=" : "addFavorite=")
                    .$product->getId()).'"').
                        ' style="position: absolute; top: -10px; left: 10px; z-index: 10;">
                    <i style="color: '.($isFavorite ? 'red' : 'black').';" class="fa '.
                        ($isFavorite ? 'fa fa-heart' : 'fa fa-heart-o').'"></i>
                </a>
                <a href="/produse?produs='.$product->getId().'">
                    <div class="card-custom-avatar">
                        <img class="img-fluid" src="'.
                        STR_AVATARS_LINK.$db->query("SELECT link FROM avatars WHERE id=".$product->getSeller())->fetchColumn().
                        '" alt="Avatar" />
                    </div>
                    <div class="product-name">'.
                        $product->getName().
                        '<p>'.($product->getSellerName()=="" ? "Necunoscut" : $product->getSellerName()).'</p>
                    </div>

                    <div class="product-description">
                        '.($product->getDescription()=="" ? 
                            "<span style='color: rgba(128, 128, 128, 0.6);'>Produs fără descriere.</span>" : $product->getDescription()).'
                    </div>
                    <div class="row">
                        <div class="col-sm-4 product-overview-p">
                            <div class="product-overview">
                                <p>PREȚ</p>
                                <h4>'.($product->getPrice()==0 ? "GRATIS" : $product->getPrice()).'</h4>
                                <sub>Lei</sub>
                            </div>
                        </div>
                        <div class="col-sm-4 product-overview-p">
                            <div class="product-overview">
                                <p>CANTITATE</p>
                                <h5>'.$product->getAmount().'</h5>
                                <sub>'.$product->getAmountType().'</sub>
                            </div>
                        </div>
                        <div class="col-sm-4 product-overview-p">
                            <div class="product-overview">
                                <p>STOC</p>
                                <h5>'.($product->getInventory()==0 ? "<span style='color: red; font-size: 12px; '>TERMINAT</span>" 
                                                                    : $product->getInventory()).'</h5>
                                <sub>'.$product->getInventoryAmountType().'</sub>
                            </div>
                        </div>
                    </div>
                </a>
            
            </div>
            
            <div class="row buyingBoxes'.($product->getInventory()==0 ? ' buyingBoxesDisabled' : '').'">
                    <div class="col-md-6" id="buyBox'.($product->getInventory()==0 ? 'Disabled' : '').'">
                        <a '.($product->getInventory()>0 ? 
                                ($user==NULL ? "onclick='mustLogin()'" : 'href="'.currentUrl().'buy='.$product->getId().'"') : "").'>
                            <i class="fa fa-credit-card"></i> Cumpără
                        </a>
                    </div>
                    <div class="col-md-6" id="addToCardBox'.($product->getInventory()==0 ? 'Disabled' : '').'">
                        <a '.($product->getInventory()>0 ? 
                                ($user==NULL ? "onclick='mustLogin()'" : 'href="'.currentUrl().'addToCard='.$product->getId().'"') : "").'>
                            <i class="fa fa-shopping-cart"></i> Adaugă în coș
                        </a>
                    </div>
                </div>

        </div>
    </div>';
}

function getSpecialCard($db, $product, $user){
    $isFavorite = isFavoriteProduct($db, $user, $product->getId());
    return
        '<div class="col-lg-3 col-md-4 col-sm-6 mix '.$product->getCategoryName().'">
        <div class="featured__item">
            <div class="featured__item__pic set-bg" data-setbg="'.STR_PRODUCTS_LINK.
                getProductImage($db, $product)
                .'">
                <ul class="featured__item__pic__hover">
                    <li><a '.($user==NULL ? "" : ('href="'.currentUrl().
                        ($isFavorite ? "removeFavorite=" : "addFavorite=")
                        .$product->getId()).'"').'>
                    <i style="color: '.($isFavorite ? 'red' : 'black').';" class="fa '.
                        ($isFavorite ? 'fa fa-heart' : 'fa fa-heart-o').'"></i>
                    <li><a '.($product->getInventory()>0 ? 
                            ($user==NULL ? "onclick='mustLogin()'" : 'href="'.currentUrl().'buy='.$product->getId().'"') : "").'>
                        <i class="fa fa-credit-card"></i></a></li>
                    <li><a '.($product->getInventory()>0 ? 
                            ($user==NULL ? "onclick='mustLogin()'" : 'href="'.currentUrl().'addToCard='.$product->getId().'"') : "").'>
                        <i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
            <div class="featured__item__text">
                <h6><a href="produse?produs='.$product->getId().'">'.$product->getName().'</a></h6>
                <h5>'.$product->getPrice().'.00 Lei</h5>
                <sub>'.($product->getInventory()>0 ? $product->getAmountType() : "<span style='color: red;'>TERMINAT</span>").'</sub>
            </div>
        </div>
    </div>';
}

function getLatestProductCard($db, $product){
    return
        '<a href="/produse?produs='.$product->getId().'" class="latest-product__item">
            <div class="latest-product__item__pic">
                <img src="'.STR_PRODUCTS_LINK.
                getProductImage($db, $product)
                .'" alt="">
            </div>
            <div class="latest-product__item__text">
                <h6>'.$product->getName().'</h6>
                <span>'.$product->getPrice().' Lei</span>
                <sub'.($product->getInventory()>0 ? ' style="color: gray;">'.$product->getAmount()." ".$product->getAmountType() : 
                            ' style="color:red;">'.'TERMINAT"').'</sub>
            </div>
        </a>';
}

function getShopcartProductCard($product){
    return
        '<tr>
        <td class="shoping__cart__item">
            <img src="images/products/'.($product['link']==FALSE ? "default.jpg" : $product['link']).'" alt="">
            <h5>'.$product['name'].'</h5>
        </td>
        <td class="shoping__cart__price">
            '.$product['price'].' Lei
        </td>
        <td>
            <div class="custom_quantity" style="margin: auto; width: 80%;">
                <a href="?minus='.$product['id'].'"><div class="custom_quantity_btn minusQuantity"> - </div></a>
                <span style="vertical-align: middle;">'.$product['amount'].'</span>
                <a href="?plus='.$product['id'].'"><div class="custom_quantity_btn plusQuantity"> + </div></a>
            </div>
        </td>
        <td class="shoping__cart__total">
            '.$product['amount']*$product['price'].' Lei
        </td>
        <td class="shoping__cart__item__close">
            <a href="?remove='.$product['id'].'"><span class="icon_close"></span></a>
        </td>
    </tr>';
}

function getHead(){
    return '
    <meta charset="UTF-8">
    <meta name="description" content="Piata agroalimentară SUCEAVA">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="piata, agro, agroalimentara, suceava, on-line, cumparaturi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/images/logo.png">

    <script src="js/a076d05399.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/product_card_style.css" type="text/css">
    ';
}

function getHeader($db, $user){
    $user_header = "";
    $bag_count = "";
    $bag_cost = 0;

    if($user == NULL){
        $user_header = '<a href="/login.php" id="loginTopRightBox"><i class="fa fa-user"></i> Login</a>';
    }
    else{
        $avatar = $db->query("SELECT link FROM avatars WHERE id=".$user->getId())->fetchColumn();
        $user_header = '<img class="avatar" src="'.STR_AVATARS_LINK.$avatar.'">';
        $user_header = $user_header . '<span style="vertical-align: middle;">'.$user->getNumeComplet().'</span>';

        /** Set the number of favorites products */
        $favorites = $db->query("SELECT count(id_product) FROM favorites WHERE id_user=".$user->getId())->fetchColumn();

        /** Set the bag products and the total cost */
        $bag = $db->query("SELECT id_produs, amount FROM bag WHERE id_user=".$user->getId())->fetchAll();
        $bag_count = count($bag);

        foreach($bag as $value){
            $bag_cost = $bag_cost + $value['amount'] * 
                $db->query("SELECT price FROM products WHERE id=".$value['id_produs'])->fetchColumn();
        }
    }  

    return '
    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-shop"></i> Market</li>
                                <li>Caută produsele de care ești interesat.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right" id="HeaderTopRightBox">
                            <div class="header__top__right__social">
                                <a href="http://usv.ro"><i class="fa ">USV</i></a>
                                <a href="https://www.facebook.com/universitateasuceava"><i class="fa fa-facebook"></i></a>
                                <a href="http://www.eed.usv.ro/fiesc/"><i class="fa fa-code"></i></a>'
                                .($user==NULL ? "" : '<a href="?logout=1"><i class="fa fa-sign-out"></i></a>').
                            '</div>
                            <div class="header__top__right__auth" id="headerTopRightAuthBox">
                                '.$user_header.'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="/portal">
                            <img width="15%" style="margin-right: 5%;" src="images/logo.png" alt="">
                            <h5 style="color: green; 
                                font-family: Ranchers; 
                                display:inline-block;
                                vertical-align: middle"><b>Piața agroalimentară<br> Suceava</b></h5>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li '.($_SERVER['SCRIPT_NAME']=='/market' ? 'class="active"' : "").
                                '><a href="/market">Market</a></li>
                            <li><a href="/portal">Portal</a></li>
                            <li '.($_SERVER['SCRIPT_NAME']=='/cumparaturi' ? 'class="active"' : "").
                            '><a href="#">Cumpărături</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="./cumparaturi">Coș de cumpărături</a></li>
                                    <li><a href="./favorites">Produse favorite</a></li>
                                    <li><a href="#">Finalizează comanda</a></li>
                                </ul>
                            </li>
                            <li '.($_SERVER['SCRIPT_NAME']=='/contact' ? 'class="active"' : "").
                            '><a href="./contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">'
                    .($user==NULL ? "" :
                    '<div class="header__cart">
                    <ul>
                        <li><a href="/favorites"><i class="fa fa-heart"></i> <span>'.$favorites.'</span></a></li>
                        <li><a href="/cumparaturi"><i class="fa fa-shopping-bag"></i> <span>
                        '.$bag_count.'
                        </span></a></li>
                    </ul>
                    <div class="header__cart__price">Coș: <span>
                        '.$bag_cost.'
                    Lei</span></div>
                </div>').
                '</div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    ';
}

function getSecondHeader($db, $categories_display=TRUE){
    $categories_list = "";

    $categories = $db->query("SELECT name FROM categories WHERE special=0");
    foreach($categories as $category){
        $categories_list = $categories_list . '<li class="all-categories ';
        if(isset($_GET['category'])){
            if($_GET['category']==$category['name']){
                $categories_list = $categories_list . 'all-categories-active';
            }
        }
        $categories_list = $categories_list . '"><a href="/market?category='.
            $category['name'].'"><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
            $category['name'].'</a></li>';
    }

    return
        '<div class="col-lg-3">
        <div class="hero__categories">
            <div class="hero__categories__all">
                <i class="fa fa-bars"></i>
                <span>Toate categoriile</span>
            </div>
            <ul '.($categories_display ? 'style="display: block;"':'style="display: none;"').'>
                '.$categories_list.'
            </ul>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="hero__search">
            <div class="hero__search__form">
                <form action="">
                    <div class="hero__search__categories">
                        Toate categoriile
                        <span class="arrow_carrot-down"></span>
                    </div>
                    <input type="text" name="search" value="" placeholder="Ce dorești să cauți?">
                    <button type="submit" class="site-btn">Caută</button>
                </form>
            </div>
            <div class="hero__search__phone">
                <div class="hero__search__phone__icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="hero__search__phone__text">
                    <h5>(+40) 749 430 000</h5>
                    <span>ai nevoie de ajutor?</span>
                </div>
            </div>
        </div>';
}

function getFooter(){
    return '<!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="images/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Adresă: Suceava, Str.Universității</li>
                            <li>Mobil: +40 749 430 000</li>
                            <li>Email: mihai.silitra@student.usv.ro | victoria.toma@student.usv.ro</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Link-uri utile</h6>
                        <ul>
                            <li><a href="#">Despre noi</a></li>
                            <li><a href="#">Despre magazin</a></li>
                            <li><a href="#">Cumpără în siguranță</a></li>
                            <li><a href="#">Informații livrare</a></li>
                            <li><a href="#">Politica de confidențialitate</a></li>
                            <li><a href="#">Harta depozitelor</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Cine suntem noi</a></li>
                            <li><a href="#">Serviciile noastre</a></li>
                            <li><a href="#">Proiecte</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Inovații</a></li>
                            <li><a href="#">Orașul Suceava</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Alătură-te grupului de oferte</h6>
                        <p>Vei primi mesaje prin email legate de noile oferte de la diverși vânzători.</p>
                        <form action="#">
                            <input type="text" placeholder="Introdu adresa ta de email">
                            <button type="submit" class="site-btn">ABONEAZĂ-TE</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="https://www.facebook.com/universitateasuceava"><i class="fa fa-facebook"></i></a>
                            <a href="http://www.eed.usv.ro/fiesc/"><i class="fa fa-code"></i></a>
                            <a href="http://usv.ro"><i class="fa">USV</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="opacity: 0.1;">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>'."
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This template is made with <i class='fa fa-heart' aria-hidden='true'></i> by 
                                <a href='https://colorlib.com' target='_blank'>Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            ".'</p>
                        </div>
                        <div class="footer__copyright__payment"><img src="images/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->'.
    STR_MUST_LOGIN;
}
