<script setup lang="ts">
import logoUrl from "../../../public/images/assets/logo.png";
import Vector from "../../../public/images/assets/Vector.png";
import banner from "../../../public/images/assets/banner.png";
import banner1 from "../../../public/images/assets/banner1.png";
import back from "../../../public/images/assets/back.png";
import fwd from "../../../public/images/assets/fwd.png";
import deal1 from "../../../public/images/assets/deal-1.png";
import deal2 from "../../../public/images/assets/deal-2.png";
import deal3 from "../../../public/images/assets/deal-3.png";
import deal4 from "../../../public/images/assets/deal-4.png";
import mdeal1 from "../../../public/images/assets/mdeal-1.png";
import mdeal2 from "../../../public/images/assets/mdeal-2.png";
import mdeal3 from "../../../public/images/assets/mdeal-3.png";
import mdeal4 from "../../../public/images/assets/mdeal-4.png";
import cartIcon from "../../../public/images/assets/cart-icon.png";
import location from "../../../public/images/assets/location.png";
import lcoationBG from "../../../public/images/assets/location-bg.png";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";



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
</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
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
            <div class="brand d-flex justify-content-between">
                <img class="img img-responsive logo" :src="logoUrl" alt="">
                <a class="theme-background-foreground phone-btn" href="tel:+1 369-256-7894" data-track-call="">
                    <div class="call-order d-flex">
                        <img class="img img-responsive" :src="Vector" alt="">
                        <div class="call-order-text d-flex flex-column">
                            <span class="label">Call and Order in</span>
                            <span class="call-to">+1 369-256-7894</span>
                        </div>
                    </div>
                </a>
            </div>
            <div id="myCarousel" class="carousel slide my-0" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item h-100 active">
                        <img :src="banner1" alt="" class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" >
                        <div class="container">
                            <div class="carousel-caption text-start customize-caption">
                                <h1 class="mb-0 text-uppercase">Italian<br><span>Burger</span></h1>
                                <p class="mb-0">With medium 2-Topping Pizza.</p>
                                <span>*Additional charge for premium toppings. Minimum of 2 required.</span>
                                <p class="cta mb-0 mt-3"><a class="btn btn-lg btn-yellow" href="#">Order Now</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img :src="banner" alt="" class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" >
                        <div class="container">
                            <div class="carousel-caption text-start customize-caption">
                                <h1 class="mb-0 text-uppercase">Italian<br><span>Burger</span></h1>
                                <p class="mb-0">With medium 2-Topping Pizza.</p>
                                <span>*Additional charge for premium toppings. Minimum of 2 required.</span>
                                <p class="cta mb-0 mt-3"><a class="btn btn-lg btn-yellow" href="#">Order Now</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item h-100">
                        <img :src="banner1" alt="" class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" >
                        <div class="container">
                            <div class="carousel-caption text-start customize-caption">
                                <h1 class="mb-0 text-uppercase">Italian<br><span>Burger</span></h1>
                                <p class="mb-0">With medium 2-Topping Pizza.</p>
                                <span>*Additional charge for premium toppings. Minimum of 2 required.</span>
                                <p class="cta mb-0 mt-3"><a class="btn btn-lg btn-yellow" href="#">Order Now</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="categories-section">
            <div class="categories-list">
                <div class="ctg-back">
                    <img :src="back" alt="">
                </div>
                <ul class="list-group">
                    <li class=""><a href="">Mighty Deals</a></li>
                    <li class=""><a href="">Online Exclusive Deals</a></li>
                    <li class=""><a href="">Gourmet Fries</a></li>
                    <li class=""><a href="">Premium Burgers</a></li>
                    <li class=""><a href="">Appetizers</a></li>
                    <li class=""><a href="">beverages</a></li>
                </ul>
                <div class="ctg-forward">
                    <img :src="fwd" alt="">
                </div>
            </div>
            <div class="categories-search">
                <form class="search-form" role="search">
                    <div class="form-group pull-right" id="search">
                        <input type="text" class="form-control" placeholder="Search">
                        <button type="submit" class="form-control form-control-submit">Submit</button>
                        <span class="search-label"><img :src="search" alt=""></span>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <main>

        <section class="base-section mighty-deals">
            <div class="container-fluid px-container">
                <h3 class="section-title text-uppercase text-center">mighty deals</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="deal1" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 01</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="deal2" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 02</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>20%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="deal3" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 03</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>30%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="deal4" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 04</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>30%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.row -->
        </section>


        <section class="base-section exclusive-deals">
            <div class="container-fluid px-container">
                <h3 class="section-title text-uppercase text-center">ONLINE EXCLUSIVE DEAL</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal1" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 01</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>10%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal2" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 02</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal3" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 03</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>10%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal4" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 04</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>30%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.row -->
        </section>


        <section class="base-section gourmet-fries">
            <div class="container-fluid px-container">
                <h3 class="section-title text-uppercase text-center">GOURMET FRIES</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal1" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 01</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>10%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal2" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 02</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal3" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 03</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>10%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="mdeal4" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">Deal 04</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. 559</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag">
                                <label>30%<br><span>OFF</span></label>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.row -->
        </section>


        <section class="base-section location-section">
            <div class="container-fluid px-container location-container">
                <h3 class="section-header text-uppercase text-center text-white">our locations</h3>
                <div class="row location-content">
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12 d-flex justify-content-center">
                        <img :src="location" alt="">
                        <p class="mb-0">Vicolo Tre Marchetti 91 Lovadina, Treviso(TV), 31027</p>
                    </div>
                </div><!-- /.row -->
            </div>
        </section>


        <section class="base-section about-section">
            <div class="container-fluid px-container about-container">
                <h3 class="section-header text-uppercase text-center">ABOUT US</h3>
                <div class="row">
                    <div class="col-xs-12 text-center px-5">
                        <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                        <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                        <p class="">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip. Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                    </div>
                </div><!-- /.row -->
            </div>
        </section>


        <!-- FOOTER -->
        <footer class="container">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2017–2022 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>
    </main>



</template>

<style>
body { padding: 0 !important; }
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
</style>

<style>
.brand {
    position: absolute;
    left: 0;
    top: 80px;
    z-index: 1;
    width: 100%;
    padding: 0px 150px;
}

.brand img.logo {
    width: 190px;
    height: 175px;
}

.brand a.phone-btn {
    text-decoration: none;
}

.call-order {
    width: 360px;
    height: 100px;
    align-items: center;
    justify-content: space-evenly;
    background: white;
    border-radius: 57px;
}

.call-order-text span.label {
    font-weight: 300;
    font-size: 16px;
    line-height: 18px;
    color: #000000;
}

.call-order-text span.call-to {
    font-weight: 800;
    font-size: 28px;
    line-height: 34px;
    color : #090909;
}

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

#myCarousel{
    width:100%;
}

#myCarousel .carousel-item img {
    object-fit: cover;
    object-position: center;
    overflow: hidden;
    height:100vh;
    width: 100%;
}

#myCarousel .customize-caption {
    top: 32%;
    left: 7.8%;
}

#myCarousel .customize-caption h1{
    font-size: 100px;
    line-height: 120px;
}

#myCarousel .customize-caption h1 span {
    font-size: 160px;
    color: #FF0000;
    margin-left:-6px;
}

#myCarousel .customize-caption p {
    font-size: 45px;
    color: #009146;
    font-weight: 400;
}

#myCarousel .customize-caption span {
    font-size: 24px;
    font-weight: 400;
}

#myCarousel .customize-caption p.cta a {
    background: #FFA52D;
    border-radius: 50px;
    width: 250px;
    height: 65px;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 400;
}

#myCarousel .carousel-indicators button {
    background: #808080;
    border-radius: 77%;
    width: 18px !important;
    height: 18px !important;
    border: 0;
}

#myCarousel .carousel-indicators button.active {
    background: #ffa800;
    width: 40px !important;
    border-radius: 10px !important;
    transition-delay: 100ms;
}

.search-form .form-group input.form-control::-webkit-input-placeholder{
    display:none;
}
.search-form .form-group input.form-control::-moz-placeholder{
    display:none;
}

.form-group{
    position:relative;
    width:0%;
    min-width:60px;
    height:60px;
    overflow:hidden;
    transition: width 1s;
    backface-visibility:hidden;
}
.form-group input.form-control{
    position:absolute;
    top:0;
    right:0;
    outline:none;
    width:100%;
    height:60px;
    margin:0;
    z-index:10;
}

input[type="text"].form-control{
    -webkit-appearence:none;
    -webkit-border-radius:0;
}
.form-control-submit, .search-label{
    width:60px;
    height:60px;
    position:absolute;
    right:0;
    top:0;
    padding:0;
    margin:0;
    text-align:center;
    cursor:pointer;
    line-height:60px;
    background:white;
}
.form-control-submit{
    background:#fff; /*stupid IE*/
    opacity: 0;
    color:transparent;
    border:none;
    outline:none;
    z-index:-1;
}
.search-label{
    z-index:90;
}
.form-group.sb-search-open,
.no-js .sb-search-open{
    width:100%;
}
.form-group.sb-search-open .search-label,
.no-js .sb-search .search-label {
    background: #da6d0d;
    color: #fff;
    z-index: 11;
}
.form-group.sb-search-open .form-control-submit,
.no-js .form-control .form-control-submit {
    z-index: 90;
}

.categories-section {
    height: 120px;
    background: #F4F4F4;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
}
.categories-list {
    width: calc( 100% - 89px );
    display: flex;
    align-items: center;
}

.categories-search {
    width: 55px;
    position: relative;
}
.categories-list ul li {
    flex: none;
    padding: 20px
}

.categories-list ul {
    width: 100%;
    flex-flow: row nowrap;
    padding: 0;
    list-style: none;
    overflow: hidden;
}

.categories-list ul li a {
    text-transform: uppercase;
    background: 0 0!important;
    color: #000;
    font-weight: 500;
    font-size: 24px;
    line-height: 36px;
    text-decoration: none;
    padding: 20px;
}

.base-section {
    margin: 60px 0;
}

.section-title {
    font-weight: 600;
    font-size: 40px;
    line-height: 60px;
    color: #000;
    margin-bottom: 60px;
}

.section-header {
    font-weight: 600;
    font-size: 60px;
    line-height: 60px;
    color: #000;
    margin-bottom: 60px;
}

.location-container {
    background-color: #B60000;
    border-radius: 30px;
    padding: 60px 0;
    background-image: url(/images/assets/location-bg.png);
    background-repeat: no-repeat;
    background-size: contain;
    background-position: 10px 20px;
}

.card-image {
    margin: 18px;
    background: #FFF6DC;
    border-radius: 30px;
    height: 320px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card-image img.card-img-top {
    max-width: 300px;
    padding: 10px;
}

.container-fluid.px-container {
    max-width: 1720px;
}

.card.deal-card {
    position: relative;
    background: #FFFFFF;
    border: 2px solid #ECECEC;
    border-radius: 30px;
}

.card.deal-card .card-title {
    font-weight: 600;
    font-size: 24px;
    color: #1E1D23;
}

.card.deal-card .card-text {
    font-weight: 400;
    font-size: 18px;
    color: #7E7E7E;
}

.card.deal-card .price-label {
    font-weight: 700;
    font-size: 24px;
    color: #00CF64;
}

.card.deal-card .discount-tag {
    position: absolute;
    width: 117px;
    height: 92px;
    left: -10px;
    top: -27px;
    background: #B60000;
    border-radius: 46px 46px 0px 46px;
    color: #FFF2F2;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}
.discount-tag label {
    font-size: 35px;
    line-height: 20px;
    text-align: right;
}

.discount-tag span {
    font-size: 16px;
}

.location-content div {
    margin-bottom: 50px;
    align-items: center;
    color: #fff;
    padding: 0 60px;
}

.location-content div img {
    margin-right: 10px;
}

.location-content div p {
    font-weight: 400;
    font-size: 24px;
}

.categories-section.fixed-top {
    top: -40px;
    transform: translateY(40px);
    transition: transform .3s;
    height: 60px;
}

.categories-section.fixed-top .categories-list img, .categories-section.fixed-top .search-label img {
    width: 36px;
}

.categories-section.fixed-top > .categories-list ul li a {
    font-size: 20px;
    padding: 15px;
}

@media (max-width: 767.98px) {
    .alert-msg {
        margin-top: 55px;
    }
}
</style>
