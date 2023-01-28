<style scoped>
@import "../../../public/css/frontend.css";
</style>

<script setup lang="ts">
import confirmation from "../../../public/images/assets/order-confirmation.png";
import bg1 from "../../../public/images/assets/bg1.png";
import logo from "../../../public/images/assets/logo.png";
import facebook from "../../../public/images/assets/facebook.png";
import youtube from "../../../public/images/assets/youtube.png";
import googlePlus from "../../../public/images/assets/google-plus.png";
import deal1 from "../../../public/images/assets/deal-1.png";
import deal2 from "../../../public/images/assets/deal-2.png";
import twitter from "../../../public/images/assets/twitter.png";
import cash from "../../../public/images/assets/cash.png";
import creditCard from "../../../public/images/assets/credit-card 1.png";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";
$(document).ready(function(){
    $('#search').on("click",(function(e){
        $(".form-group").addClass("sb-search-open");
        e.stopPropagation()
    }));
    $(document).on("click", function(e) {
        if ($(e.target).is("#search") === false && $(".form-control").val().length == 0) {
            $(".form-group").removeClass("sb-search-open");
        }
    });
    $(".form-control-submit").click(function(e){
        $(".form-control").each(function(){
            if($(".form-control").val().length == 0){
                e.preventDefault();
                $(this).css('border', '2px solid red');
            }
        });
    });

    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();

        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    };

    $(window).on('resize scroll', function() {
        if ($('#mainHeaderSection').isInViewport()) {
            $('.categories-section').removeClass('fixed-top');
        } else {
            $('.categories-section').addClass('fixed-top');
        }
    });
});

</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png"
          sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32"
          type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16"
          type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg"
          color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <section id="mainHeaderSection">
        <div class="container-fluid p-0">
            <div class="alert-msg text-light">FREE Delivery On Orders Above <span>Rs. 2000</span></div>
            <header class="d-block d-md-none">
                <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="checkout-brand d-flex justify-content-between">
                <img class="img background position-relative w-100" :src="bg1" alt="">
                <div class="w-100 d-flex flex-column justify-content-center align-items-center text-center checkout-logo">
                    <img class="img img-responsive logo" :src="logo" alt="">
                    <h2 class="text-uppercase">DELIVERY INFORMATION</h2>
                </div>
            </div>
        </div>
    </section>

    <main>

        <section id="checkoutForm">
            <div class="container-fluid">
                <div class="row py-5">
                    <div class="billing-details col-md-6 col-xs-12 px-4 mb-5">
                        <h3 class="text-capitalize mb-4">Billing details</h3>
                        <form class="row g-5">
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">First Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputFirstName" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">Last Name <sup class="text-danger">*</sup></label>
                                <input type="password" class="form-control" id="inputLastName" placeholder="Enter your last name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPhone" class="form-label">Phone Number <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputPhone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAlternativeNumber" class="form-label">Alternate Number</label>
                                <input type="text" class="form-control" id="inputAlternativeNumber">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Delivery Address <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="Enter your complete address" required>
                            </div>
                            <div class="col-12">
                                <label for="inputInstructions" class="form-label">Delivery Instructions</label>
                                <input type="text" class="form-control" id="inputInstructions" placeholder="Enter any instruction or note to rider">
                            </div>
                            <div class="col-md-6">
                                <label for="inputLandmark" class="form-label">Nearest Landmark</label>
                                <input type="text" class="form-control" id="inputLandmark" placeholder="Any famous place nearby">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="inputEmail" placeholder="Please enter your email">
                            </div>
                            <div class="col-12">
                                <h6 class="text-capitalize">PAYMENT INFORMATION</h6>

                                <div class="payment-selector mt-4 d-flex">
                                    <div class="cash col-sm-4 d-flex flex-column justify-content-center align-items-center">
                                        <img name="onCash" class="img img-responsive" :src="cash" alt="">
                                        <label for="onCash">Cash</label>
                                    </div>
                                    <span class="col-sm-1">&nbsp;</span>
                                    <div class="online col-sm-4 d-flex flex-column justify-content-center align-items-center">
                                        <img name="onCard" class="img img-responsive" :src="creditCard" alt="">
                                        <label for="onCard">Online Payment</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-xs-12 px-4">
                        <div class="order-details px-4 py-5">
                            <div class="order-heading d-flex justify-content-between">
                                <label for="">Your Order</label>
                                <label for="">Subtotal</label>
                            </div>
                            <hr class="hr">
                            <!-- Order ITEMS - to be looped through -->
                            <div class="order-list d-flex align-items-center">
                                <div class="order-image d-flex">
                                    <img class="img" :src="deal1" alt="">
                                    <hr class="order-image-separator">
                                </div>
                                <div class="order-item d-flex justify-content-between align-items-center w-100">
                                    <div class="item-name px-3">
                                        <h6 class="text-capitalize">Italian Burger</h6>
                                        <span>With cheese</span>
                                        <span>Bacon (Rs. 10.00)</span>
                                    </div>
                                    <p class="item-value mb-0">Rs. 559</p>
                                </div>
                            </div>
                            <div class="order-list d-flex align-items-center">
                                <div class="order-image d-flex">
                                    <img class="img" :src="deal2" alt="">
                                    <hr class="order-image-separator">
                                </div>
                                <div class="order-item d-flex justify-content-between align-items-center w-100">
                                    <div class="item-name px-3">
                                        <h6 class="text-capitalize">Crunch burger with coke</h6>
                                        <span>With cheese</span>
                                        <span>Bacon (Rs. 10.00)</span>
                                    </div>
                                    <p class="item-value mb-0">Rs. 1099</p>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="order-summary d-flex justify-content-between">
                                <div class="summary-labels">
                                    <p>Subtotal</p>
                                    <p class="mb-0">Delivery Fee</p>
                                </div>
                                <div class="summary-values text-right">
                                    <p>Rs. 559</p>
                                    <p class="mb-0">Rs. 79</p>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="order-total d-flex justify-content-between">
                                <label for="">Total</label>
                                <span>Rs. 638</span>
                            </div>
                            <div class="order-voucher mt-3">
                                <label>Voucher</label>
                                <div class="voucher-input d-flex justify-content-between">
                                    <input type="text" class="mr-2" placeholder="Enter Voucher here">
                                    <button class="btn btn-warning">Apply</button>
                                </div>
                            </div>

                            <button class="btn btn-warning btn-submit mt-3">Place Order</button>
                            <a href="#" class="continue-shopping">Continue Shopping</a>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.row -->
        </section>


        <!-- FOOTER -->
        <footer class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="social-icons mb-3 d-inline-flex">
                <img :src="facebook" alt="facebook icon">
                <img :src="googlePlus" alt="google icon">
                <img :src="twitter" alt="twitter icon">
                <img :src="youtube" alt="youtube icon">
            </div>
            <p class="mb-0">Copyright &copy; 2023 <span class="color-1">FastBurger</span>. All Rights Reserved.</p>
        </footer>
    </main>


</template>


