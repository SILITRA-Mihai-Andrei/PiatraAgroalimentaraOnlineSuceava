<?php

// Links
define('STR_AVATARS_LINK', 'images/avatars/');
define('STR_PRODUCTS_LINK', 'images/products/');

// How date is named in database
define('STR_ID_DB', 'idUtilizator');
define('STR_USER_DB', 'user');
define('STR_NAME_DB', 'NumeComplet');
define('STR_EMAIL_DB', 'Email');
define('STR_PASSWORD_DB', 'Parola');
define('STR_TYPE_DB', 'Tip');
define('STR_DEPOSIT_DB', "Depozit");

// SESSION
define('STR_SESSION_USER', 'userObject');

// The names of fields for $_GET
define('STR_GET_REGISTER_BTN', 'registerBtn');
define('STR_GET_LOGIN_BTN', 'loginBtn');
define('STR_GET_REGISTER', 'registrationType');
define('STR_GET_NAME', 'NumeComplet');
define('STR_GET_USER', 'user');
define('STR_GET_EMAIL', 'Email');
define('STR_GET_PASSWORD', 'Parola');
define('STR_GET_MOBILE', 'Telefon');
define('STR_GET_LOCALITY', 'Localitate');
define('STR_GET_ADDRESS', 'Adresa');
define('STR_GET_DEPOSIT', 'Depozit');

// The name of boxes under which the PHP server will insert invalid warnings
define('STR_NAME_BOX', 'NameBox');
define('STR_USER_BOX', 'UserBox');
define('STR_EMAIL_BOX', 'EmailBox');
define('STR_PASSWORD_BOX', 'PasswordBox');
define('STR_MOBILE_BOX', 'MobileBox');
define('STR_LOCALITY_BOX', 'LocalityBox');
define('STR_ADDRESS_BOX', 'AdressBox');
define('STR_REGISTER_BOX', 'registerBox');
define('STR_LOGIN_BOX', 'loginBox');

// The name of boxes for MARKET PAGE
define('STR_MARKET_HEADER_TOP_RIGHT_AUTH', 'headerTopRightAuthBox');
define('STR_MARKET_LOGIN_BOX', 'loginTopRightBox');

// Strings
define('STR_SESSION_EXPIRED', "<script>alert('Sesiunea de logare a expirat. Trebuie să te autentifici din nou!');</script>");

// Strings for invalid warnings
define('STR_DATABASE_ERROR_RECEIVE', 'Eroare la baza de date!');
define('STR_USER_PASSWORD_INVALID', 'Nu a fost găsit nici un utilizator cu numele de utilizator și parola introduse de dumneavostră!');
define('STR_EMAIL_PASSWORD_INVALID', 'Nu a fost găsit nici un utilizator cu adresa de email și parola introduse de dumneavostră!');
define('STR_USER_ALREADY_EXISTS', 'Nume de utilizator deja utilizat!');
define('STR_EMAIL_ALREADY_EXISTS', 'Adresa de email există deja!');
define('STR_NAME_EMPTY', 'Numele complet trebuie completat!');
define('STR_USER_EMPTY', 'Numele de utilizator trebuie completat!');
define('STR_EMAIL_EMPTY', 'Adresa de email trebuie completată!');
define('STR_PASSWORD_EMPTY', 'Parola trebuie completată!');
define('STR_USER_INVALID', 'Numele de utilizator este invalid!');
define('STR_EMAIL_INVALID', 'Adresa de email este invalidă!');
define('STR_MOBILE_INVALID', 'Numărul de telefon nu este valid!');

define('STR_MUST_LOGIN_TEXT', "Trebuie să te loghezi pentru a utiliza magazinul!");
define('STR_MUST_LOGIN_SHOPING_CART_TEXT', "Trebuie să te loghezi pentru a putea adăuga produse în coș!");

define('STR_MUST_LOGIN', '<script>function mustLogin(){alert("'.STR_MUST_LOGIN_TEXT.'");}</script>');
