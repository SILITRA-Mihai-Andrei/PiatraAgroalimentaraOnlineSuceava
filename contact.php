<?php

require_once('variables.php');
require_once('strings.php');
require_once ("utils.php");
require_once('UserClass.php');
require_once('ProductClass.php');

session_start();
if( isset($_GET['logout'])){
    session_destroy();
    header("Location: /login.php");
}

$user = NULL;
if(isset($_SESSION[STR_SESSION_USER])){
    $user = $_SESSION[STR_SESSION_USER];
}

?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Contact</title>
    <?php echo getHead(); ?>
</head>

<body>
    
    <?php echo getHeader($db, $user); ?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Telefon</h4>
                        <p>(+40) 749 430 000</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Adresă</h4>
                        <p>Suceava, str.Universității</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Program de lucru</h4>
                        <p>24/7 la numărul de telefon</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>toma.victoria@student.usv.ro sau mihai.silitra@student.usv.ro</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    
    <!-- Map Begin -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49116.39176087041!2d-86.41867791216099!3d39.69977417971648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x886ca48c841038a1%3A0x70cfba96bf847f0!2sPlainfield%2C%20IN%2C%20USA!5e0!3m2!1sen!2sbd!4v1586106673811!5m2!1sen!2sbd"
            height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4>Suceava</h4>
                <ul>
                    <li>Telefon: (+40) 749 430 000</li>
                    <li>str.Universității, Universitatea ”Ștefan cel Mare” Suceava</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Map End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Scrie-ne un mesaj</h2>
                    </div>
                </div>
            </div>
            <form action="#">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Numele tău complet">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Adresa ta de email">
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea placeholder="Mesajul tău"></textarea>
                        <button type="submit" class="site-btn">TRIMITE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Contact Form End -->

    <?php echo getFooter(); ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>



</body>

</html>