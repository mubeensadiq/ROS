<style>
@import "../../../public/css/frontend.css";
</style>
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

import _ from "lodash";
import { ref, reactive , onMounted } from "vue";

import axios from "axios";
const data = reactive({ categories: [], dealProducts:[], categoryProducts: [] })
onMounted(() => {
    getCategories();
   // getDealProducts();
    getCategoryProducts();
})

const getCategories = (() => {
    axios.get('/api/categories?get=all&status=1').then((response)=>{
        data.categories = response.data.categories;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getDealProducts = (() => {
    axios.get('/api/deal-products').then((response)=>{
        data.dealProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getCategoryProducts = (() => {
    axios.get('/api/category-products').then((response)=>{
        data.categoryProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">

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
                    <li v-for="(category,index) in data.categories" class="" ><a :href="'#'+category.id">{{category.name}}</a></li>
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


        <section v-for="(category , index) in data.categoryProducts" class="base-section gourmet-fries" :id="category.id">
            <div class="container-fluid px-container">
                <h3 class="section-title text-uppercase text-center">{{category.name}}</h3>
                <div class="row">
                    <div v-for="(product , index) in category.products" class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                        <div class="card deal-card">
                            <div class="card-image"><img class="card-img-top" :src="'/images/products/'+product.image" alt="Card image cap"></div>
                            <div class="card-body">
                                <h5 class="card-title">{{product.name}}</h5>
                                <p class="card-text">{{product.description}} </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="price-label">Rs. {{product.price}}</label>
                                    <img :src="cartIcon" alt="">
                                </div>
                            </div>
                            <div class="discount-tag hidden">
                                <label>10%<br><span>OFF</span></label>
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

