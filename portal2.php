<?php

require_once('variables.php');
require_once('strings.php');
require_once ("utils.php");
require_once ("ProductClass.php");

if(isset($_GET['cumpara'])){
    header("Location: /market");
}
else if(isset($_GET['vinde'])){
    header("Location: /vinde");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Piata Agroalimentara Suceava</title>
    <link rel="icon" href="/images/logo.png">
    <!-- custom-theme -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="piata, agro, agroalimentara, suceava, on-line, cumparaturi" />
    <!-- //custom-theme -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/style_portal.css" rel="stylesheet" type="text/css" media="all" />
    <!-- js -->
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <!-- //js -->
    <link href="css/mislider.css" rel="stylesheet" type="text/css" />
    <link href="css/mislider-custom.css" rel="stylesheet" type="text/css" />
    <!-- font-awesome-icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome-icons -->
    <link href="http://fonts.googleapis.com/css?family=Bree+Serif&amp;subset=latin-ext" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- banner -->
    <div class="banner" style="height: 100vh;">
        <div class="container">
            <div class="w3_agileits_banner_main_grid">
                <div class="w3_agile_logo">
                    <h1>
                        <a href="http://primariasv.ro/portal/suceava/portal.nsf/Index/100?OpenDocument">
                            <span>Suceava</span> Piață agroalimentară<i style="text-align: center;">on-line</i>
                        </a>
                    </h1>
                </div>
                <div class="agile_social_icons_banner">
                    <ul class="agileits_social_list">
                        <li><a href="http://usv.ro"><i class="fa " aria-hidden="true ">USV</i></a></li>
                        <li><a href="/contact"><i class="fa fa-user-md " aria-hidden="true "></i></a></li>
                        <li><a href="https://www.facebook.com/universitateasuceava"><i class="fa fa-facebook " aria-hidden="true "></i></a></li>
                    </ul>
                </div>
                <div class="agileits_w3layouts_menu ">
                    <div class="shy-menu ">
                        <a class="shy-menu-hamburger ">
                            <span class="layer top "></span>
                            <span class="layer mid "></span>
                            <span class="layer btm "></span>
                        </a>
                        <div class="shy-menu-panel ">
                            <nav class="menu menu--horatio link-effect-8 " id="link-effect-8 ">
                                <ul class="w3layouts_menu__list ">
                                    <li class="active "><a href="/market ">Market</a></li>
                                    <li><a href="/contact ">Contact</a></li>
                                    <li><a href="/cumparaturi ">Coș cumpărături</a></li>
                                    <li><a href="/register.php ">Register</a></li>
                                    <li><a href="/login.php ">Login</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="clearfix "> </div>
                    </div>
                </div>
                <div class="clearfix "> </div>
            </div>
            <div class="w3_banner_info ">
                <div class="w3_banner_info_grid ">
                    <h3 class="test ">Mulțumim pentru atenție!</h3><br>
                    <h3 class="test ">TOMA Victoria</h3><br>
                    <h3 class="test ">SILITRĂ Mihai-Andrei</h3><br><br><br><br><br><br>
                    <ul>
                        <li><a href="?vinde=true" class="w3l_contact ">Vinde</a></li>
                        <li><a href="?cumpara=true" class="w3ls_more " data-toggle="modal " data-target="#myModal ">Cumpără</a></li>
                    </ul>
                </div>
            </div>
            <div class="thim-click-to-bottom ">
                <a href="#welcome_bottom " class="scroll ">
                    <i class="fa fa-chevron-down "></i>
                </a>
            </div>
        </div>
    </div>
    <!-- banner -->

    <!-- banner-bottom -->
    <div class="banner-bottom">
        <div class="col-md-4 agileits_banner_bottom_left">
            <div class="agileinfo_banner_bottom_pos">
                <div class="w3_agileits_banner_bottom_pos_grid">
                    <div class="col-xs-4 wthree_banner_bottom_grid_left">
                        <div class="agile_banner_bottom_grid_left_grid hvr-radial-out">
                            <i class="glyphicon glyphicon-headphones" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xs-8 wthree_banner_bottom_grid_right">
                        <h4>Consultații gratuite</h4>
                        <p>Oferim suport tehnic tuturor cumpărătorilor și vânzătorilor.</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 agileits_banner_bottom_left1">
            <div class="agileinfo_banner_bottom_pos">
                <div class="w3_agileits_banner_bottom_pos_grid">
                    <div class="col-xs-4 wthree_banner_bottom_grid_left">
                        <div class="agile_banner_bottom_grid_left_grid hvr-radial-out">
                            <i class="fa fa-certificate" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xs-8 wthree_banner_bottom_grid_right">
                        <h4>Produse certificate</h4>
                        <p>Produsele certificate afișate cu prioritate în magazin.</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 agileits_banner_bottom_left2">
            <div class="agileinfo_banner_bottom_pos">
                <div class="w3_agileits_banner_bottom_pos_grid">
                    <div class="col-xs-4 wthree_banner_bottom_grid_left">
                        <div class="agile_banner_bottom_grid_left_grid hvr-radial-out">
                            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xs-8 wthree_banner_bottom_grid_right">
                        <h4>Comandă la ușa ta</h4>
                        <p>Majoritatea vânzătorilor îți pot trimite produsele prin curier.</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!-- //banner-bottom -->
    <!-- welcome -->
    <div class="welcome">
        <div class="container">
            <h3 class="agileits_w3layouts_head">Bun venit pe <span>plantația</span> noastră</h3>
            <div class="w3_agile_image">
                <img src="images/1.png" alt=" " class="img-responsive" />
            </div>
            <p class="agile_para">Ne asigurăm mereu că vei cumpăra doar produse de calitate.</p>
        </div>
        <div class="mis-stage w3_agileits_welcome_grids">
            <!-- The element to select and apply miSlider to - the class is optional -->
            <ol class="mis-slider">
                <?php 
                    $products = ProductClass::loadProducts($db);
                    $counter = 1;
                    if($products != FALSE and count($products) > 0){
                        foreach($products as $product){
                            if($counter++ >= 10) break;
                            echo '
                                <li class="mis-slide">
                                    <figure>
                                        <img src="images/products/'.$product->getId().'.jpg" alt=" " class="img-responsive" />
                                        <figcaption>'.$product->getName().'</figcaption>
                                    </figure>
                                </li>';
                            $counter++;
                        }
                    }
                ?>
            </ol>
        </div>
    </div>
    <!-- //welcome -->
    <!-- welcome-bottom -->
    <div id="welcome_bottom" class="welcome-bottom">
        <div class="col-md-6 wthree_welcome_bottom_left">
            <h3>E timpul pentru <span>digitalizare!</span></h3>
            <p>Pandemia de COVID-19 ne-a oferit ocazia unei digitalizări mai rapide.
                Este unul din motivele pentru care am dezvoltat această piată on-line pentru SUCEAVA!  
            </p>
            <div class="col-md-6 wthree_welcome_bottom_left_grid">
                <div class="w3l_social_icon_gridl">
                    <img src="images/8.png" alt=" " class="img-responsive" />
                </div>
                <div class="w3l_social_icon_gridr">
                    <h4 class="counter">20,000</h4>
                </div>
                <div class="clearfix"> </div>
                <div class="w3l_social_icon_grid_pos">
                    <label>-</label>
                </div>
            </div>
            <div class="col-md-6 wthree_welcome_bottom_left_grid">
                <div class="w3l_social_icon_gridl">
                    <img src="images/9.png" alt=" " class="img-responsive" />
                </div>
                <div class="w3l_social_icon_gridr">
                    <h4 class="counter">50,000</h4>
                </div>
                <div class="clearfix"> </div>
                <div class="w3l_social_icon_grid_pos">
                    <label>-</label>
                </div>
            </div>
            <div class="col-md-6 wthree_welcome_bottom_left_grid">
                <div class="w3l_social_icon_gridl">
                    <img src="images/10.png" alt=" " class="img-responsive" />
                </div>
                <div class="w3l_social_icon_gridr">
                    <h4 class="counter">40,000</h4>
                </div>
                <div class="clearfix"> </div>
                <div class="w3l_social_icon_grid_pos">
                    <label>-</label>
                </div>
            </div>
            <div class="col-md-6 wthree_welcome_bottom_left_grid">
                <div class="w3l_social_icon_gridl">
                    <img src="images/11.png" alt=" " class="img-responsive" />
                </div>
                <div class="w3l_social_icon_gridr">
                    <h4 class="counter">12,000</h4>
                </div>
                <div class="clearfix"> </div>
                <div class="w3l_social_icon_grid_pos">
                    <label>-</label>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="col-md-6 wthree_welcome_bottom_right">
            <div class="agileinfo_grid">
                <figure class="agileits_effect_moses">
                    <img src="images/4.jpg" alt=" " class="img-responsive" />
                    <figcaption>
                        <h4>Produse <span>100% românești</span></h4>
                        <p>Susținem toate produsele românești din județul Suceava și nu numai.</p>
                    </figcaption>
                </figure>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!-- //welcome-bottom -->
    <!-- news -->
    <div class="welcome">
        <div class="container">
            <h3 class="agileits_w3layouts_head"><span>Noutăți</span> pe platformă</h3>
            <div class="w3_agile_image">
                <img src="images/1.png" alt=" " class="img-responsive">
            </div>
            <p class="agile_para">Vezi cele mai noi implementări aduse magazinului on-line.</p>
            <div class="w3ls_news_grids">
                <div class="col-md-4 w3ls_news_grid">
                    <div class="w3layouts_news_grid">
                        <img src="images/avatars.jpg" alt=" " class="img-responsive img-responsive-custom" />
                        <div class="w3layouts_news_grid_pos">
                            <div class="wthree_text">
                                <h3>Avatare</h3>
                            </div>
                        </div>
                    </div>
                    <div class="agileits_w3layouts_news_grid">
                        <ul>
                            <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date("d l Y"); ?></li>
                            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Administrator</a></li>
                        </ul>
                        <h4><a href="#" data-toggle="modal" data-target="#myModal">Implementarea poze profil</a></h4>
                        <p>De acum fiecare produs este afișat cu poza de profil a vânzătorului!</p>
                    </div>
                </div>
                <div class="col-md-4 w3ls_news_grid">
                    <div class="w3layouts_news_grid">
                        <img src="images/special.jpg" alt=" " class="img-responsive img-responsive-custom" />
                        <div class="w3layouts_news_grid_pos">
                            <div class="wthree_text">
                                <h3>Special</h3>
                            </div>
                        </div>
                    </div>
                    <div class="agileits_w3layouts_news_grid">
                        <ul>
                            <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date("d l Y", strtotime('-2 days')); ?></li>
                            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Administrator</a></li>
                        </ul>
                        <h4><a href="#" data-toggle="modal" data-target="#myModal">Produse speciale</a></h4>
                        <p>Acum puteți găsi pe magazinul nostru și produse speciale, cum ar fi animăluțe.</p>
                    </div>
                </div>
                <div class="col-md-4 w3ls_news_grid">
                    <div class="w3layouts_news_grid">
                        <img src="images/rating.jpg" alt=" " class="img-responsive img-responsive-custom" />
                        <div class="w3layouts_news_grid_pos">
                            <div class="wthree_text">
                                <h3>Rating</h3>
                            </div>
                        </div>
                    </div>
                    <div class="agileits_w3layouts_news_grid">
                        <ul>
                            <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date("d l Y", strtotime('-5 days')); ?></li>
                            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Administrator</a></li>
                        </ul>
                        <h4><a href="#" data-toggle="modal" data-target="#myModal">Produse după rating</a></h4>
                        <p>În sfârșit! Poți găsi produse filtrate automat după rating.</p>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <!-- //news -->
    <!-- newsletter -->
    <div class="newsletter">
        <div class="container">
            <h3 class="agileits_w3layouts_head agileinfo_head"><span>Abonează-te</span> la revista de năutăți</h3>
            <div class="w3_agile_image">
                <img src="images/12.png" alt=" " class="img-responsive">
            </div>
            <p class="agile_para agileits_para">Primești mesaje prin email cu cele mai noi oferte de pe piața noastră.</p>
            <div class="w3ls_news_grids w3ls_newsletter_grids">
                <form action="#" method="post">
                    <input name="Name" placeholder="Numele tău complet" type="text" required="">
                    <input name="Email" placeholder="Adresa ta de email" type="email" required="">
                    <input type="submit" value="ABONEAZĂ-TE!">
                </form>
            </div>
        </div>
    </div>
    <!-- //newsletter -->
    <!-- footer -->
    <div class="footer">
        <div class="container">
            <div class="w3agile_footer_grids">
                <div class="col-md-3 agileinfo_footer_grid">
                    <div class="agileits_w3layouts_footer_logo">
                        <h2><a href="index.html"><span>SUCEAVA</span>Piața ta agroalimentară<i>On-line</i></a></h2>
                    </div>
                </div>
                <div class="col-md-4 agileinfo_footer_grid">
                    <h3>Informații de contact</h3>
                    <h4>Sună-ne <span>(+40) 749 430 000</span></h4>
                    <p>Suceava, str.Universității <span>Universitatea ”Ștefan cel Mare”.</span></p>
                    <ul class="agileits_social_list">
                        <li><a href="https://www.facebook.com/universitateasuceava" class="w3_agile_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="http://usv.ro" class="agile_twitter"><i class="fa " aria-hidden="true">USV</i></a></li>
                        <li><a href="http://usv.ro" class="w3_agile_dribble"><i class="fa fa-code" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-2 agileinfo_footer_grid agileinfo_footer_grid1">
                    <h3>Navigare</h3>
                    <ul class="w3layouts_footer_nav">
                        <li><a href="/market"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Market</a></li>
                        <li><a href="/cumparaturi"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Coș cumpărături</a></li>
                        <li><a href="/register.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Înregistrează-te</a></li>
                        <li><a href="/login.php"><i class="fa fa-long-arrow-right" aria-hidden="true"></i>Loghează-te</a></li>
                    </ul>
                </div>
                <div class="col-md-3 agileinfo_footer_grid">
                    <h3>Sociale</h3>
                    <div class="agileinfo_footer_grid_left">
                        <a href="#" data-toggle="modal" data-target="#myModal"><img src="images/products/10.jpg" alt=" " class="img-responsive" /></a>
                    </div>
                    <div class="agileinfo_footer_grid_left">
                        <a href="#" data-toggle="modal" data-target="#myModal"><img src="images/special.jpg" alt=" " class="img-responsive" /></a>
                    </div>
                    <div class="agileinfo_footer_grid_left">
                        <a href="#" data-toggle="modal" data-target="#myModal"><img src="images/rating.jpg" alt=" " class="img-responsive" /></a>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <div class="w3_agileits_footer_copy" style="opacity: 0.3;">
            <div class="container">
                <p>© 2017 Germinate. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts.</a></p>
            </div>
        </div>
    </div>
    <!-- //footer -->
    <!-- stats -->
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.countup.js"></script>
    <script>
        $('.counter').countUp();
    </script>
    <!-- //stats -->
    <!-- mislider -->
    <script src="js/mislider.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(function($) {
            var slider = $('.mis-stage').miSlider({
                //  The height of the stage in px. Options: false or positive integer. false = height is calculated using maximum slide heights. Default: false
                stageHeight: 380,
                //  Number of slides visible at one time. Options: false or positive integer. false = Fit as many as possible.  Default: 1
                slidesOnStage: false,
                //  The location of the current slide on the stage. Options: 'left', 'right', 'center'. Defualt: 'left'
                slidePosition: 'center',
                //  The slide to start on. Options: 'beg', 'mid', 'end' or slide number starting at 1 - '1','2','3', etc. Defualt: 'beg'
                slideStart: 'mid',
                //  The relative percentage scaling factor of the current slide - other slides are scaled down. Options: positive number 100 or higher. 100 = No scaling. Defualt: 100
                slideScaling: 150,
                //  The vertical offset of the slide center as a percentage of slide height. Options:  positive or negative number. Neg value = up. Pos value = down. 0 = No offset. Default: 0
                offsetV: -5,
                //  Center slide contents vertically - Boolean. Default: false
                centerV: true,
                //  Opacity of the prev and next button navigation when not transitioning. Options: Number between 0 and 1. 0 (transparent) - 1 (opaque). Default: .5
                navButtonsOpacity: 1,
            });
        });
    </script>
    <!-- //mislider -->
    <!-- text-effect -->
    <script type="text/javascript" src="js/jquery.transit.js"></script>
    <script type="text/javascript" src="js/jquery.textFx.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.test').textFx({
                type: 'fadeIn',
                iChar: 100,
                iAnim: 1000
            });
        });
    </script>
    <!-- //text-effect -->
    <!-- menu -->
    <script>
        $(function() {

            initDropDowns($("div.shy-menu"));

        });

        function initDropDowns(allMenus) {

            allMenus.children(".shy-menu-hamburger").on("click", function() {

                var thisTrigger = jQuery(this),
                    thisMenu = thisTrigger.parent(),
                    thisPanel = thisTrigger.next();

                if (thisMenu.hasClass("is-open")) {

                    thisMenu.removeClass("is-open");

                } else {

                    allMenus.removeClass("is-open");
                    thisMenu.addClass("is-open");
                    thisPanel.on("click", function(e) {
                        e.stopPropagation();
                    });
                }

                return false;
            });
        }
    </script>
    <!-- //menu -->
    <!-- start-smoth-scrolling -->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!-- start-smoth-scrolling -->
    <!-- for bootstrap working -->
    <script src="js/bootstrap.js"></script>
    <!-- //for bootstrap working -->
    <!-- here stars scrolling icon -->
    <script type="text/javascript">
        $(document).ready(function() {
            /*
            	var defaults = {
            	containerID: 'toTop', // fading element id
            	containerHoverID: 'toTopHover', // fading element hover id
            	scrollSpeed: 1200,
            	easingType: 'linear' 
            	};
            */

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <!-- //here ends scrolling icon -->
</body>

</html>