<?php
require_once('connect.php');

function login($conn) {
    setcookie('token', "", 0, "/");
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $sql = 'SELECT * FROM users WHERE email = ? AND password = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($email, $password))) {
        $valid = false;
        while ($row = $stmt->fetch()) {
            $valid = true;
            $token = generateToken();
            $sql = 'UPDATE users SET token = ? WHERE email = ?';
            $stmt1 = $conn->prepare($sql);
            if ($stmt1->execute(array($token, $email))) {
                setcookie('token', $token, 0, "/");
                echo 'Login Successful';
            }
        }
        if(!$valid) {
            echo 'Email or Password Incorrect';
        }
    }
}

function register($conn) {
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $token = generateToken();
    $sql = 'INSERT INTO users (password, email, token) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    try {
        if ($stmt->execute(array($password, $email, $token))) {
            setcookie('token', $token, 0, "/");
            $sql = 'INSERT INTO orders (users_id, status) (SELECT u.id, "new" FROM users u WHERE u.token = ?)';
            $stmt1 = $conn->prepare($sql);
            if ($stmt1->execute(array($token))) {
                echo 'Account Registered';
            }
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function generateToken() {
    $date = date(DATE_RFC2822);
    $rand = rand();
    return sha1($date.$rand);
}
if(isset($_POST['login'])) {
    login($dbh);
}

if(isset($_POST['register'])) {
    register($dbh);
}


function addProduct($conn, $id) {
    $token = getToken();
    $sql = 'INSERT INTO orders_products (orders_id, products_id) (SELECT o.id, ? FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" WHERE u.token = ?)';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($id, $token))) {
    }
}
function deleteProduct($conn, $id) {
    $token = getToken();
    $sql = 'DELETE op FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id WHERE u.token = ? AND op.id = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token, $id))) {
    }
}
function getProducts($conn)
{
    $token = getToken();
    $sql = 'SELECT p.name, p.price, p.preview, op.id FROM users u LEFT JOIN orders o ON u.id = o.users_id AND o.status = "new" LEFT JOIN orders_products op ON o.id = op.orders_id LEFT JOIN products p ON op.products_id = p.id WHERE u.token = ?';
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($token))) {
        while ($row = $stmt->fetch()) {
            if ($row['id'] != null) {
                echo '<div>
                   <div class="col-sm-4 col-lg-4 col-md-4" >
                       <div class="thumbnail" style="height:550px;" >
                           <img src="' . $row["preview"] . '">

                   Name: ' . $row['name'] . '<br>
                   Price: $' . $row['price'] . '<br>
                   <form method="post" action="cart.php">
                       <input type="hidden" name="id" value="' . $row['id'] . '"/>
                       <input type="submit" name="delete" value="DELETE"/> Delete
                   </form>
                   </div></div>
                   </div>';


            }
        }
    }
}
function getToken() {
    if (isset($_COOKIE['token'])) {
        return $_COOKIE['token'];
    }
    else {
    }
}
if(isset($_POST['add'])) {
    $id = $_POST['id'];
    addProduct($dbh, $id);
}
if(isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteProduct($dbh, $id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>The Jetta Shop</title>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="jquery.easing.min.js"></script>
    <script src="shop.js"></script>
    <style>
        #Osamacare {
            position: absolute;
            top:1020px;
            height: 90px
        }

        .prettyline {
            height: 5px;
            border-top: 0;
            background: #c4e17f;
            border-radius: 5px;

        }
        body {
            width: 100%;
            height: 100%;
        }

        html {
            width: 100%;
            height: 100%;
        }

        @media(min-width:767px) {
            .navbar {
                padding: 20px 0;
                -webkit-transition: background .5s ease-in-out,padding .5s ease-in-out;
                -moz-transition: background .5s ease-in-out,padding .5s ease-in-out;
                transition: background .5s ease-in-out,padding .5s ease-in-out;
            }

            .top-nav-collapse {
                padding: 0;
            }
        }


        .intro-section {
            height: 100%;
            padding-top: 150px;
            text-align: center;
            background: #fff;
        }

        .about-section {
            height: 100%;
            padding-top: 150px;
            text-align: center;
            background: #eee;
        }

        .services-section {
            height: 100%;
            padding-top: 150px;
            text-align: center;
            background: #fff;
        }

        .contact-section {
            height: 100%;
            padding-top: 150px;
            text-align: center;
            background: #eee;
        }
    </style>
</head>
<body onload="onLoad()">
<script>

    $(window).scroll(function() {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    $(function() {
        $('a.page-scroll').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
    });
    jQuery.easing.jswing = jQuery.easing.swing;
    jQuery.extend(jQuery.easing, {
        def: "easeOutQuad",
        swing: function(e, f, a, h, g) {
            return jQuery.easing[jQuery.easing.def](e, f, a, h, g)
        },
        easeInQuad: function(e, f, a, h, g) {
            return h * (f /= g) * f + a
        },
        easeOutQuad: function(e, f, a, h, g) {
            return -h * (f /= g) * (f - 2) + a
        },
        easeInOutQuad: function(e, f, a, h, g) {
            if ((f /= g / 2) < 1) {
                return h / 2 * f * f + a
            }
            return -h / 2 * ((--f) * (f - 2) - 1) + a
        },
        easeInCubic: function(e, f, a, h, g) {
            return h * (f /= g) * f * f + a
        },
        easeOutCubic: function(e, f, a, h, g) {
            return h * ((f = f / g - 1) * f * f + 1) + a
        },
        easeInOutCubic: function(e, f, a, h, g) {
            if ((f /= g / 2) < 1) {
                return h / 2 * f * f * f + a
            }
            return h / 2 * ((f -= 2) * f * f + 2) + a
        },
        easeInQuart: function(e, f, a, h, g) {
            return h * (f /= g) * f * f * f + a
        },
        easeOutQuart: function(e, f, a, h, g) {
            return -h * ((f = f / g - 1) * f * f * f - 1) + a
        },
        easeInOutQuart: function(e, f, a, h, g) {
            if ((f /= g / 2) < 1) {
                return h / 2 * f * f * f * f + a
            }
            return -h / 2 * ((f -= 2) * f * f * f - 2) + a
        },
        easeInQuint: function(e, f, a, h, g) {
            return h * (f /= g) * f * f * f * f + a
        },
        easeOutQuint: function(e, f, a, h, g) {
            return h * ((f = f / g - 1) * f * f * f * f + 1) + a
        },
        easeInOutQuint: function(e, f, a, h, g) {
            if ((f /= g / 2) < 1) {
                return h / 2 * f * f * f * f * f + a
            }
            return h / 2 * ((f -= 2) * f * f * f * f + 2) + a
        },
        easeInSine: function(e, f, a, h, g) {
            return -h * Math.cos(f / g * (Math.PI / 2)) + h + a
        },
        easeOutSine: function(e, f, a, h, g) {
            return h * Math.sin(f / g * (Math.PI / 2)) + a
        },
        easeInOutSine: function(e, f, a, h, g) {
            return -h / 2 * (Math.cos(Math.PI * f / g) - 1) + a
        },
        easeInExpo: function(e, f, a, h, g) {
            return (f == 0) ? a : h * Math.pow(2, 10 * (f / g - 1)) + a
        },
        easeOutExpo: function(e, f, a, h, g) {
            return (f == g) ? a + h : h * (-Math.pow(2, -10 * f / g) + 1) + a
        },
        easeInOutExpo: function(e, f, a, h, g) {
            if (f == 0) {
                return a
            }
            if (f == g) {
                return a + h
            }
            if ((f /= g / 2) < 1) {
                return h / 2 * Math.pow(2, 10 * (f - 1)) + a
            }
            return h / 2 * (-Math.pow(2, -10 * --f) + 2) + a
        },
        easeInCirc: function(e, f, a, h, g) {
            return -h * (Math.sqrt(1 - (f /= g) * f) - 1) + a
        },
        easeOutCirc: function(e, f, a, h, g) {
            return h * Math.sqrt(1 - (f = f / g - 1) * f) + a
        },
        easeInOutCirc: function(e, f, a, h, g) {
            if ((f /= g / 2) < 1) {
                return -h / 2 * (Math.sqrt(1 - f * f) - 1) + a
            }
            return h / 2 * (Math.sqrt(1 - (f -= 2) * f) + 1) + a
        },
        easeInElastic: function(f, h, e, l, k) {
            var i = 1.70158;
            var j = 0;
            var g = l;
            if (h == 0) {
                return e
            }
            if ((h /= k) == 1) {
                return e + l
            }
            if (!j) {
                j = k * 0.3
            }
            if (g < Math.abs(l)) {
                g = l;
                var i = j / 4
            } else {
                var i = j / (2 * Math.PI) * Math.asin(l / g)
            }
            return -(g * Math.pow(2, 10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j)) + e
        },
        easeOutElastic: function(f, h, e, l, k) {
            var i = 1.70158;
            var j = 0;
            var g = l;
            if (h == 0) {
                return e
            }
            if ((h /= k) == 1) {
                return e + l
            }
            if (!j) {
                j = k * 0.3
            }
            if (g < Math.abs(l)) {
                g = l;
                var i = j / 4
            } else {
                var i = j / (2 * Math.PI) * Math.asin(l / g)
            }
            return g * Math.pow(2, -10 * h) * Math.sin((h * k - i) * (2 * Math.PI) / j) + l + e
        },
        easeInOutElastic: function(f, h, e, l, k) {
            var i = 1.70158;
            var j = 0;
            var g = l;
            if (h == 0) {
                return e
            }
            if ((h /= k / 2) == 2) {
                return e + l
            }
            if (!j) {
                j = k * (0.3 * 1.5)
            }
            if (g < Math.abs(l)) {
                g = l;
                var i = j / 4
            } else {
                var i = j / (2 * Math.PI) * Math.asin(l / g)
            } if (h < 1) {
                return -0.5 * (g * Math.pow(2, 10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j)) + e
            }
            return g * Math.pow(2, -10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j) * 0.5 + l + e
        },
        easeInBack: function(e, f, a, i, h, g) {
            if (g == undefined) {
                g = 1.70158
            }
            return i * (f /= h) * f * ((g + 1) * f - g) + a
        },
        easeOutBack: function(e, f, a, i, h, g) {
            if (g == undefined) {
                g = 1.70158
            }
            return i * ((f = f / h - 1) * f * ((g + 1) * f + g) + 1) + a
        },
        easeInOutBack: function(e, f, a, i, h, g) {
            if (g == undefined) {
                g = 1.70158
            }
            if ((f /= h / 2) < 1) {
                return i / 2 * (f * f * (((g *= (1.525)) + 1) * f - g)) + a
            }
            return i / 2 * ((f -= 2) * f * (((g *= (1.525)) + 1) * f + g) + 2) + a
        },
        easeInBounce: function(e, f, a, h, g) {
            return h - jQuery.easing.easeOutBounce(e, g - f, 0, h, g) + a
        },
        easeOutBounce: function(e, f, a, h, g) {
            if ((f /= g) < (1 / 2.75)) {
                return h * (7.5625 * f * f) + a
            } else {
                if (f < (2 / 2.75)) {
                    return h * (7.5625 * (f -= (1.5 / 2.75)) * f + 0.75) + a
                } else {
                    if (f < (2.5 / 2.75)) {
                        return h * (7.5625 * (f -= (2.25 / 2.75)) * f + 0.9375) + a
                    } else {
                        return h * (7.5625 * (f -= (2.625 / 2.75)) * f + 0.984375) + a
                    }
                }
            }
        },
        easeInOutBounce: function(e, f, a, h, g) {
            if (f < g / 2) {
                return jQuery.easing.easeInBounce(e, f * 2, 0, h, g) * 0.5 + a
            }
            return jQuery.easing.easeOutBounce(e, f * 2 - g, 0, h, g) * 0.5 + h * 0.5 + a
        }
    });

</script>
<div class="container-fluid">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="color: white"  href="index%20(7).html"><b>Volkswagen</b></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-2">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="page-scroll" href="#top">Home</a></li>
                    <li><a class="page-scroll" href="#about">About</a></li>
                    <li><a class="page-scroll" href="#pro">Products/Services</a></li>
                    <li>
                        <a class="  btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Login/Sign-in</a>
                    </li>
                </ul>
                <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">
                    <form method="post" action="" class="navbar-form navbar-right form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="Email">Email</label>
                            <input type="email" name="email" class="form-control" id="Email" placeholder="Email" autofocus required />
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="Password">Password</label>
                            <input type="password" name="password" lass="form-control" id="Password" placeholder="Password" required />
                        </div>
                        <input type="submit" class="btn btn-success" name="login" value="LOGIN">
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>
<div id="top" align="center" class="jumbotron" style="background-color: white;">
    <h1>The Jetta Shop</h1>
    <img src="http://blog.resonate.com/wp-content/uploads/2015/09/Volkswagen-Logo.jpg">
</div>
<div class="bs-example" data-example-id="simple-thumbnails">
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <a class="thumbnail" href="#"><img alt="100%x180"
                                               data-holder-rendered="true" data-src="holder.js/100%x180" src=
                                                       "https://data.motor-talk.de/data/galleries/0/205/2026/44917084/volkswagen-jetta-vi-01-850048764930266898.jpg"
                                               style="height: 180px; width: 100%; display: block;"></a>
        </div>


        <div class="col-xs-6 col-md-3">
            <a class="thumbnail" href="#"><img alt="100%x180"
                                               data-holder-rendered="true" data-src="holder.js/100%x180" src=
                                                       "http://img.mx.autos.cozot.com/pics/mx/2014/10/09/Jetta-standar-01-20141009010226.jpg"
                                               style="height: 180px; width: 100%; display: block;"></a>
        </div>


        <div class="col-xs-6 col-md-3">
            <a class="thumbnail" href="#"><img alt="100%x180"
                                               data-holder-rendered="true" data-src="holder.js/100%x180" src=
                                                       "http://www.carbodykitstore.com/images/EDfbk/ED-104581.jpg"
                                               style="height: 180px; width: 100%; display: block;"></a>
        </div>


        <div class="col-xs-6 col-md-3">
            <a class="thumbnail" href="#"><img alt="100%x180"
                                               data-holder-rendered="true" data-src="holder.js/100%x180" src=
                                                       "http://img.mx.autos.cozot.com/pics/mx/2014/12/28/Jetta-modificado-01-20141228041124.jpg"
                                               style="height: 180px; width: 100%; display: block;"></a>
        </div>
    </div>
</div>
<br><br>
<div class="well well-lg jumbotron">
    <section class="about-section" id="about">
        <div id="Osamacare"  align="center">
            <h2>About Us</h2>
            <br>
            <p>The goal of this website is to fuel an old memory, an almost antique rarely seen anymore today.
                The 01 Jettas as well as other Volkswagen brand names at the time gave reliability a whole new meaning.
                This site honors these points and gives light to the future as we give users the option to purchase
                these incredible cars.</p>
        </div>
    </section>
</div>
<br><br>
<section class="pro-section" id="pro">
    <div style="background-color: dodgerblue;">
        <br><br>
        <h1 align="center">Interested in owning one yourself?</h1>
        <p align="center"><i>These offers are both few and time limited, order your Jetta now or risk not being able to own
            your very own!<i></p>
        <div class="bs-example" data-example-id="thumbnails-with-custom-content">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                                "holder.js/100%x200" src=
                                     "http://i.ebayimg.com/00/s/NTIxWDY4MQ==/z/GYcAAOSwL7VWjo-m/$_35.JPG"
                             style="height: 200px; width: 100%; display: block;">

                        <div class="caption">
                            <h3 class="item_price">$1500</h3>


                            <p>This sporty looking Jetta gives their connoisseur a rush to drive on the track or just
                                a casual ride on the road. This car is time limited and will go soon! So buy now before
                                this awesome car has a new owner.
                            </p>
                            <form action="cart.php" method="post">
                            <p><a class="btn btn-primary item_add" href="cart.php" role=
                                "button" onclick="addProduct('product_1')">Buy Now!</a></p>
                            </form>
                        </div>

                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                                "holder.js/100%x200" src=
                                     "http://germancarsforsaleblog.com/wp-content/uploads/2015/10/012-570x428.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                        <div class="caption">
                            <h3 class="item_price">$2000</h3>


                            <p>An older model yet exciting to say the least, this offers an all around experience for Jetta maniacs like myself, a little faster yet still all around safe and reliable.</p>


                            <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_2')">Buy Now!</a></p>
                        </div>
                        </form>
                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                                "holder.js/100%x200" src=
                                     "http://www.vwvortex.com/artman/uploads/ab_kidshorty_03.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                        <div class="caption">
                            <h3 class="item_price">$2500</h3>


                            <p>This is meant for a true speed demon, racing grade wheels as well as an engine swap to top it all off. I bet an englishman could smell the petrol all the way from here!</p>


                            <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_3')">Buy Now!</a></p>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pro-section" id="pro">
    <div style="background-color: dodgerblue;">
        <br><br>
        <div class="bs-example" data-example-id="thumbnails-with-custom-content">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://static.cargurus.com/images/site/2008/06/24/22/26/2001_volkswagen_jetta_gls-pic-16581-1600x1200.jpeg"
                             style="height: 200px; width: 100%; display: block;">

                        <div class="caption">
                            <h3 class="item_price">$1500</h3>


                            <p>This Jetta gives their connoisseur a rush to drive on the track or just
                                a casual ride on the road. This car is time limited and will go soon! So buy now before
                                this awesome car has a new owner.
                            </p>
                            <form action="cart.php" method="post">
                                <p><a class="btn btn-primary item_add" href="cart.php" type="submit" name="addProduct" role=
                                    "button" onclick="addProduct('product_4')">Buy Now!</a></p>
                            </form>
                        </div>

                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "https://media.ed.edmunds-media.com/volkswagen/jetta/2001/oem/2001_volkswagen_jetta_sedan_glx-vr6_fq_oem_1_300.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                            <div class="caption">
                                <h3 class="item_price">$2000</h3>


                                <p>An older model yet exciting to say the least, this offers an all around experience for Jetta maniacs like myself, a little faster yet still all around safe and reliable.</p>


                                <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_5')">Buy Now!</a></p>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://www.runwalkjog.com/rhodeislandcars/providence/01volkswagenjetta51108.JPG"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                            <div class="caption">
                                <h3 class="item_price">$2500</h3>


                                <p>This is meant for a true speed demon, racing grade wheels as well as an engine swap to top it all off. I bet an englishman could smell the petrol all the way from here!</p>


                                <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_6')">Buy Now!</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="pro-section" id="pro">
    <div style="background-color: dodgerblue;">
        <br><br>
        <div class="bs-example" data-example-id="thumbnails-with-custom-content">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://image.superstreetonline.com/f/30210095+w+h+q80+re0+cr1/eurp_1102_01_o%2B2001_vw_jetta%2Bleft_side_view.jpg"
                             style="height: 200px; width: 100%; display: block;">

                        <div class="caption">
                            <h3 class="item_price">$1500</h3>


                            <p>This sporty looking Jetta gives their connoisseur a rush to drive on the track or just
                                a casual ride on the road. This car is time limited and will go soon! So buy now before
                                this awesome car has a new owner.
                            </p>
                            <form action="cart.php" method="post">
                                <p><a class="btn btn-primary item_add" href="cart.php" type="submit" name="addProduct" role=
                                    "button" onclick="addProduct('product_7')">Buy Now!</a></p>
                            </form>
                        </div>

                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://www.gotshadeonline.com/wp-content/gallery/2001-volkswagen-jetta/01-volkswagen-jetta-04.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                            <div class="caption">
                                <h3 class="item_price">$2000</h3>


                                <p>An older model yet exciting to say the least, this offers an all around experience for Jetta maniacs like myself, a little faster yet still all around safe and reliable.</p>


                                <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_8')">Buy Now!</a></p>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://www.vwvortex.com/artman/uploads/ab_kidshorty_03.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                            <div class="caption">
                                <h3 class="item_price">$2500</h3>


                                <p>This is meant for a true speed demon, racing grade wheels as well as an engine swap to top it all off. I bet an englishman could smell the petrol all the way from here!</p>


                                <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('9')">Buy Now!</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail simpleCart_shelfItem">
                        <img alt="100%x200" data-holder-rendered="true" data-src=
                        "holder.js/100%x200" src=
                             "http://carphotos.cardomain.com/ride_images/4/295/4241/38237120012_original.jpg"
                             style="height: 200px; width: 100%; display: block;">
                        <form>
                            <div class="caption">
                                <h3 class="item_price">$2500</h3>


                                <p>An older model yet exciting to say the least, this offers an all around experience for Jetta maniacs like myself, a little faster yet still all around safe and reliable.</p>


                                <p><a class="btn btn-primary item_add" href="cart.php" role=
                                    "button" onclick="addProduct('product_10')">Buy Now!</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Button trigger modal -->

<div class="container">
    <hr class="prettyline">
    <br>
    <center>
        <h1><b>Sign-Up Here!</b></h1>
        <h3></h3>
        <br>
        <button class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm" >Register</button>
    </center>
    <br>
    <hr class="prettyline">
</div>


<!-- Modal -->

<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <br>
            <nav>
                <div class="bs-example bs-example-tabs">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
                        <li class=""><a href="#why" data-toggle="tab">Why?</a></li>
                    </ul>
            </nav>
        </div>
        <div style="background-color: white;" class="modal-body">
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in" id="why">
                    <p>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
                    <p></p><br> Please contact <a mailto:href="Dalton.Turner@west-mec.org"></a>Dalton.Turner@west-mec.org</a> for any other inquiries.</p>
                </div>
                <div class="tab-pane fade" id="signup">
                    <form method="post" action="" class="form-horizontal">
                        <fieldset>
                            <!-- Sign Up Form -->
                            <!-- Text input-->
                            <div class="control-group">
                                <label class="control-label" for="Email">Email:</label>
                                <div class="controls">
                                    <input id="Email" name="email" class="form-control" type="text" placeholder="DaltonT@west-mec.org" class="input-large" required="">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="control-group">
                                <label class="control-label" for="userid">Alias:</label>
                                <div class="controls">
                                    <input id="userid" name="userid" class="form-control" type="text" placeholder="Dalton Turner" class="input-large" required="">
                                </div>
                            </div>

                            <!-- Password input-->
                            <div class="control-group">
                                <label class="control-label" for="password">Password:</label>
                                <div class="controls">
                                    <input id="password" name="password" class="form-control" type="password" placeholder="********" class="input-large" required="">
                                    <em>1-8 Characters</em>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="control-group">
                                <label class="control-label" for="reenterpassword">Re-Enter Password:</label>
                                <div class="controls">
                                    <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="********" class="input-large" required="">
                                </div>
                            </div>

                            <!-- Multiple Radios (inline) -->
                            <br>
                            <div class="control-group" align="center">
                                <label class="control-label" for="humancheck">Humanity Check:</label>
                                <div class="controls">
                                    <label class="radio inline" for="humancheck-0">
                                        <input type="radio" name="humancheck" id="humancheck-0" value="robot" checked="checked">I'm a Robot</label>
                                    <label class="radio inline" for="humancheck-1">
                                        <input type="radio" name="humancheck" id="humancheck-1" value="human">I'm Human</label>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="control-group" align="center">
                                <label class="control-label" for="confirmsignup"></label>
                                <div class="controls">
                                    <input type="submit"  name="register" value="Sign Up" id="confirmsignup" class="btn btn-success">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <center>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </center>
        </div>
    </div>
</div>
</div>
</body>
</html>
