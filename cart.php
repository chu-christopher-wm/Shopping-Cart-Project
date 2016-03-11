<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <script src="jquery.easing.min.js"></script>
    <script src="shop.js"></script>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="card.css">
    <script src="card.js"></script>
    <style>
        body {
            background-color: dodgerblue;
        }
    </style>
</head>
<body onload="pullCart()">
<h1>Cart Checkout</h1>
<div align="center" class="container">

    <!-- Modal -->
    <div align="center" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
                    <!-- Vendor libraries -->
                    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

                    <!-- If you're using Stripe for payments -->
                    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

                    <div class="container">
                        <div class="row">
                            <!-- You can make it whatever width you want. I'm making it full width
                                 on <= small devices and 4/12 page width on >= medium devices -->
                            <div class="col-xs-12 col-md-4">


                                <!-- CREDIT CARD FORM STARTS HERE -->
                                <div style="margin-left: 40%; margin-top: 20%; position: absolute;" class="panel panel-default credit-card-box">
                                    <div class="panel-heading display-table" >
                                        <div class="row display-tr" >
                                            <h3 class="panel-title display-td" >Payment Details</h3>
                                            <div class="display-td" >
                                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form role="form" id="payment-form">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label for="cardNumber">CARD NUMBER</label>
                                                        <div class="input-group">
                                                            <input
                                                                type="tel"
                                                                class="form-control"
                                                                name="cardNumber"
                                                                placeholder="Valid Card Number"
                                                                autocomplete="cc-number"
                                                                required autofocus
                                                                />
                                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7 col-md-7">
                                                    <div class="form-group">
                                                        <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                                        <input
                                                            type="tel"
                                                            class="form-control"
                                                            name="cardExpiry"
                                                            placeholder="MM / YY"
                                                            autocomplete="cc-exp"
                                                            required
                                                            />
                                                    </div>
                                                </div>
                                                <div class="col-xs-5 col-md-5 pull-right">
                                                    <div class="form-group">
                                                        <label for="cardCVC">CV CODE</label>
                                                        <input
                                                            type="tel"
                                                            class="form-control"
                                                            name="cardCVC"
                                                            placeholder="CVC"
                                                            autocomplete="cc-csc"
                                                            required
                                                            />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <button class="btn btn-success btn-lg btn-block" type="submit">Purchase</button>
                                                </div>
                                            </div>
                                            <div class="row" style="display:none;">
                                                <div class="col-xs-12">
                                                    <p class="payment-errors"></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- CREDIT CARD FORM ENDS HERE -->


                            </div>

                        </div>
                    </div>
            </div>

        </div>
    </div>

</div>

<table style=width:75% id="cartList">
    <tr>
        <td style=width:75%><h4>Product</h4></td>
        <td><h4>Amount</h4></td>
        <td><h4>Price</h4></td>
    </tr>

</table>
<div>

</div><br><br>

<a href="index.php">Back</a>
<div id="amount"></div>
<div id="priceAmount"></div><br>
<button type="button" data-toggle="modal" data-target="#myModal">Checkout</button>
<br>
<br>
<br>
<h3 id="noProducts"></h3>

<br>
<br>
<br>
<div>
    <br>

</div>
</body>
</html>