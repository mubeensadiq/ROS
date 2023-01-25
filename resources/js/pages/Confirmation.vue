<style scoped>
@import "https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css";
@import "https://getbootstrap.com/docs/5.3/examples/carousel/carousel.css";
.bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
}

@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}

.b-example-divider {
    height: 3rem;
    background-color: rgba(0, 0, 0, .1);
    border: solid rgba(0, 0, 0, .15);
    border-width: 1px 0;
    box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

.b-example-vr {
    flex-shrink: 0;
    width: 1.5rem;
    height: 100vh;
}

.bi {
    vertical-align: -.125em;
    fill: currentColor;
}

.nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
}

.nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
/* TOP ALERT */
.alert-msg {
    background-color: #090909;
    height: 60px;
    padding: 15px 0;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
}

.alert-msg span {
    color: #FAC031;
}

/* Banner */
.checkout-brand img.background {
    height: 460px;
}

.checkout-brand .checkout-logo {
    position: absolute;
    color: white;
    height: 450px;
}

.checkout-brand .checkout-logo img.logo {
    width: 244px;
}

.checkout-brand .checkout-logo h2 {
    font-weight: 600;
    font-size: 60px;
}

/* Checkout Form */
#checkoutForm {
    box-shadow: 0px 1px 50px rgb(0 0 0 / 5%);
    border-radius: 10px;
    margin: 100px 70px;
}

.billing-details p {
    font-weight: 300;
    font-size: 24px;
    color: #090808;
}

.billing-details p span {
    font-weight: 600;
    font-size: 24px;
    color: #1E1D23;
}

.order-details {
}

.hr {
    border-color: #D0D0D0;
}

.text-right {
    text-align: right;
}

.order-total label {
    font-weight: 600;
    font-size: 24px;
}

.summary-values p {
    font-weight: 400;
}

.order-total span {
    font-weight: 700;
    font-size: 25px;
    color: #00CF64;
}

.order-list img { max-width: 120px; }
.order-image-separator { border: 1px dashed #000000; }
.order-item .item-name h6 {
    font-weight: 600;
    font-size: 20px;
}
.order-item .item-name p, .order-item .item-name span {
    font-weight: 300;
    font-size: 16px;
}
.order-item .item-value {
    font-weight: 700;
    font-size: 20px;
    color: #00CF64;
}

footer {
    height: 225px;
    background: #000;
}

footer p {
    color: #898989;
    font-weight: 300;
    font-size: 24px;
}

.color-1 {
    color: #FFA52D
}

@media (max-width: 767.98px) {
    .alert-msg {
        margin-top: 55px;
    }
}
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
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";


</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

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
                    <div class="col-md-12 text-center">
                        <img :src="confirmation" alt="">
                        <h3 class="text-capitalize my-5">Your Order Details</h3>
                    </div>
                    <div class="billing-details col-md-5 col-xs-12 px-4 mb-5">
                        <p>Your order from: <span>Restaurant Name</span></p>
                        <p>Delivery address: <span>1, D, 8 Khaliq-uz-Zaman Rd</span></p>
                        <p>Order number: <span>#ASFD-69832</span></p>
                    </div>
                    <div class="col-md-7 col-xs-12 px-4">
                        <div class="order-details px-4">
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
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.row -->
        </section>


        <!-- FOOTER -->
        <footer class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="social-icons mb-3">
                <img :src="facebook" alt="facebook icon">
                <img :src="googlePlus" alt="google icon">
                <img :src="twitter" alt="twitter icon">
                <img :src="youtube" alt="youtube icon">
            </div>
            <p class="mb-0">Copyright &copy; 2023 <span class="color-1">Fastburger</span>. All Rights Reserved.</p>
        </footer>
    </main>


</template>


