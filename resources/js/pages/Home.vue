<style scoped>
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
import facebook from "../../../public/images/assets/facebook.png";
import youtube from "../../../public/images/assets/youtube.png";
import googlePlus from "../../../public/images/assets/google-plus.png";
import twitter from "../../../public/images/assets/twitter.png";
import deleteIcon from "../../../public/images/assets/delete.png";
import shoppingCartIcon from "../../../public/images/assets/shopping-cart.png";

import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js";



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
const data = reactive({ categories: [],deals: [], dealProducts:[], categoryProducts: [] })
onMounted(() => {
    getCategories();
    getDeals();
   // getDealProducts();
    getCategoryProducts();

    $(window).on('load', function() {
        $('#selectLocationModal').modal('show');

        $(".region-city").select2({
            placeholder: "Select city",
            dropdownParent: $('#selectLocationModal'),
            width: '100%',
            allowClear: true
        });
        $(".region-area").select2({
            placeholder: "Select area",
            dropdownParent: $('#selectLocationModal'),
            width: '100%',
            allowClear: true
        });
        $(".region-branch").select2({
            placeholder: "Select branch",
            dropdownParent: $('#selectLocationModal'),
            width: '100%',
            allowClear: true
        });
    });
})

const getCategories = (() => {
    axios.get('/categories?get=all&status=1').then((response)=>{
        data.categories = response.data.categories;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getDeals = (() => {
    axios.get('/deals?get=all&status=1').then((response)=>{
        data.deals = response.data.deals;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getDealProducts = (() => {
    axios.get('/deal-products').then((response)=>{
        data.dealProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getCategoryProducts = (() => {
    axios.get('/category-products').then((response)=>{
        data.categoryProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.3/examples/carousel/carousel.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

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
            <div class="shopping-cart">
				<div class="shopping-icon" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
					<span class="badge bg-dark rounded-circle p-2">03</span>
					<img class="img img-responsive img-circle" :src="shoppingCartIcon" alt="">
				</div>
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
                    <li v-for="(deal,index) in data.deals" class="" ><a :href="'#'+deal.id">{{deal.name}}</a></li>
                    <li v-for="(category,index) in data.categories" class="" ><a :href="'#'+category.id">{{category.name}}</a></li>
                </ul>
                <div class="ctg-forward">
                    <img :src="fwd" alt="">
                </div>
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
                                    <img data-bs-toggle="modal" data-bs-target="#productModal" :src="cartIcon" alt="">
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
        <footer class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="social-icons mb-3 d-inline-flex">
                <img :src="facebook" alt="facebook icon">
                <img :src="googlePlus" alt="google icon">
                <img :src="twitter" alt="twitter icon">
                <img :src="youtube" alt="youtube icon">
            </div>
            <p class="mb-0">Copyright &copy; 2023 <span class="color-1">FastBurger</span>. All Rights Reserved.</p>
        </footer>



		<!-- Region Modal -->
		<div class="modal fade" id="selectLocationModal" aria-labelledby="selectLocationModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content p-3">
					<div class="modal-header border-0 d-flex justify-content-center">
						<img :src="logoUrl" class="img" alt="">
					</div>
					<div class="modal-body locationModal">
						<div class="row">
							<div class="col-sm-12">
								<div class="select-region mb-3 bordered text-center">
									<h3 class="text-capitalize">Please select your area</h3>
									<div class="btn-group text-capitalize" role="group" aria-label="Basic radio toggle button group">
										<input type="radio" class="btn-check" name="regionRadio" id="deleveryRadio" autocomplete="off" checked>
										<label class="btn btn-outline-primary" for="deleveryRadio">Delivery</label>

										<input type="radio" class="btn-check" name="regionRadio" id="pickupRadio" autocomplete="off">
										<label class="btn btn-outline-primary" for="pickupRadio">Pickup</label>
									</div>
								</div>


								<div class="mb-3 select-city">
									<select class="selectable-region py-3 region-city form-control form-select w-100" name="city" id="regionCity">
										<option value="karachi">Karachi</option>
										<option value="lahore">Lahore</option>
									</select>
								</div>


								<div class="select-area">
									<select class="selectable-region py-3 region-area form-control form-select w-100" name="area" id="regionArea">
										<option value="gulshan">Gulshan</option>
										<option value="shahrahfaisal">Shahrah e Faisal</option>
										<option value="karimabad">Karimabad</option>
										<option value="dak-khana">Dak Khana</option>
										<option value="johar">Gulistan e Johar</option>
									</select>
								</div>


								<div class="select-branch">
									<select class="selectable-region py-3 region-branch form-control form-select w-100" name="branch" id="regionBranch">
										<option value="pechs">PECHS</option>
										<option value="smchs">Sindhi Muslim (SMCHS)</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- shoppingCartModal -->
		<div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content p-3">
					<div class="modal-header border-0 d-flex align-items-start">
						<h5 class="modal-title text-dark px-4" id="shoppingCartModalLabel">Add to Cart</h5>
						<button type="button" class="btn-close border rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body cartModal">
						<div class="row">
							<div class="col-md-8 col-sm-12">
								<table class="table">
									<thead>
									<tr>
										<th scope="col"></th>
										<th scope="col">Product</th>
										<th scope="col">Price</th>
										<th scope="col">Quantity</th>
										<th scope="col">Subtotal</th>
										<th scope="col"></th>
									</tr>
									</thead>
									<tbody>
										<tr>
											<th style="width:10%;" scope="row">
												<div class="order-image d-flex">
													<img class="img" :src="deal1" alt="">
													<hr class="order-image-separator">
												</div>
											</th>
											<th>
												<div class="order-item d-flex justify-content-between align-items-center w-100">
													<div class="item-name px-3">
														<h6 class="text-capitalize">Italian Burger</h6>
														<span>With cheese</span>
														<span>Bacon (Rs. 10.00)</span>
													</div>

												</div>
											</th>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td style="width:10%;"><input type="number" class="w-100" placeholder="0"></td>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td><a href="#"><img class="img remove-item" :src="deleteIcon" alt=""></a></td>
										</tr>
										<tr>
											<th style="width:10%;" scope="row">
												<div class="order-image d-flex">
													<img class="img" :src="deal1" alt="">
													<hr class="order-image-separator">
												</div>
											</th>
											<th>
												<div class="order-item d-flex justify-content-between align-items-center w-100">
													<div class="item-name px-3">
														<h6 class="text-capitalize">Italian Burger</h6>
														<span>With cheese</span>
														<span>Bacon (Rs. 10.00)</span>
													</div>

												</div>
											</th>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td style="width:10%;"><input type="number" class="w-100" placeholder="0"></td>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td><a href="#"><img class="img remove-item" :src="deleteIcon" alt=""></a></td>
										</tr>
										<tr>
											<th style="width:10%;" scope="row">
												<div class="order-image d-flex">
													<img class="img" :src="deal1" alt="">
													<hr class="order-image-separator">
												</div>
											</th>
											<th>
												<div class="order-item d-flex justify-content-between align-items-center w-100">
													<div class="item-name px-3">
														<h6 class="text-capitalize">Italian Burger</h6>
														<span>With cheese</span>
														<span>Bacon (Rs. 10.00)</span>
													</div>

												</div>
											</th>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td style="width:10%;"><input type="number" class="w-100" placeholder="0"></td>
											<td><p class="item-value mb-0">Rs. 559</p></td>
											<td><a href="#"><img class="img remove-item" :src="deleteIcon" alt=""></a></td>
										</tr>
									</tbody>
								</table>

								<button class="btn btn-yellow float-end">Update cart</button>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="cart-total px-3 py-4">
									<div class="cart-summary">
										<h6>Cart Totals</h6>
										<div class="order-total d-flex justify-content-between">
											<p class="total-label">Subtotal</p>
											<span class="text-dark">Rs. 559</span>
										</div>
										<hr>
										<div class="order-total d-flex justify-content-between">
											<p class="total-label">Total</p>
											<span>Rs. 638</span>
										</div>
									</div>
									<div class="proceed-cart text-center mt-3">
										<a href="checkout.html" class="btn btn-yellow">Proceed to checkout</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Product Modal -->
		<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content p-3">
					<div class="modal-header border-0 d-flex align-items-start">
						<button type="button" class="btn-close border rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body cartModal">
						<div class="row">
							<div class="productSlideshow position-relative col-md-6 col-sm-12">
								<div id="carouselExampleIndicators" class="mb-0 carousel slide" data-bs-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item active">
											<img :src="deal1" class="img" alt="...">
										</div>
										<div class="carousel-item">
											<img :src="deal2" class="img" alt="...">
										</div>
										<div class="carousel-item">
											<img :src="deal3" class="img" alt="...">
										</div>
									</div>
									<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
										<span class="carousel-control-prev-icon" aria-hidden="true"></span>
										<span class="visually-hidden">Previous</span>
									</button>
									<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
										<span class="carousel-control-next-icon" aria-hidden="true"></span>
										<span class="visually-hidden">Next</span>
									</button>
								</div>
								<div class="carousel-indicators">
									<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img :src="deal1" class="d-block" alt="..."></button>
									<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"><img :src="deal2" class="d-block" alt="..."></button>
									<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"><img :src="deal3" class="d-block" alt="..."></button>
								</div>
							</div>
							<div class="productSummary col-md-6 col-sm-12">
								<div class="product-n-review">
									<h3>ItalianBurger</h3>
									<div class="reviews star-gold">
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-fill"></i>
										<i class="bi bi-star-half"></i>
										<i class="bi bi-star"></i>
									</div>
									<p class="mb-3">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eius mod tempor incididunt ut labore et dolore magna aliqua.</p>
									<p class="mb-2">Rs. 559</p>
								</div>
								<hr class="hr">
								<div class="preferences mb-3">
									<h6>Choose Your Preference</h6>
									<label for=""><input type="radio" name="" id="" checked> with cheese</label>
								</div>
								<div class="drinks mb-3">
									<h6>Select your Drink</h6>
									<label for=""><input type="radio" name="" id="" checked> Pepsi</label>
									<label for=""><input type="radio" name="" id="" > 7up</label>
									<label for=""><input type="radio" name="" id="" > Miranda</label>
									<label for=""><input type="radio" name="" id="" > Dew</label>
									<label for=""><input type="radio" name="" id="" > Diet 7up</label>
								</div>
								<hr class="hr">
								<div class="toppings mb-3">
									<h6>More Topping</h6>
									<label for=""><input type="checkbox" name="" id="" checked> Cheese (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> American Sausage (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> Bacon (Rs. 10.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> Chicken (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> Pineapple (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> German (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> Ham (Rs. 20.00)</label>
									<label for=""><input type="checkbox" name="" id="" checked> Black olives (Rs. 20.00)</label>
								</div>
								<div class="instructions mb-3">
									<h6>Special Instructions</h6>
									<textarea class="form-control w-100" name="" id="" cols="30" rows="5"></textarea>
								</div>
								<hr class="hr">
								<div class="d-flex justify-content-between">
									<label for="">1 Italian Burger</label>
									<span>Rs. 550</span>
								</div>
								<hr class="hr">
								<div class="total-values">
									<label for="">Total</label>
									<span>Rs. 550</span>
								</div>

								<div class="range-add-button">
									<input type="number" name="1" id="" value="1">
									<button class="btn btn-yellow float-end">Add to cart</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </main>
</template>
