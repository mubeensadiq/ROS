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
import {ref, reactive, onMounted, watch} from "vue";
import TomSelect from "../base-components/TomSelect";
import {
    FormInput,
    FormInline,
    FormSelect,
    FormLabel,
    FormHelp,
    FormCheck,
    InputGroup,
    FormSwitch,
} from "../base-components/Form";
import axios from "axios";
import Tippy from "../base-components/Tippy";
const data = reactive({
    cities: [],
    areas: [],
    branches: [],
    categories: [],
    deals: [],
    dealProducts:[],
    categoryProducts: [],
    selectedProduct : null,
    locationType: 'Delivery'
})
const city = ref('');
const area = ref('');
const branch = ref('');
watch(city, async (newCity) => {
    getAreas();
    getBranches();
})
watch(city, async (newCity) => {
    getAreas();
    getBranches();
})
watch(area, async(val) => {
    getCategoryProducts();
    $('#selectLocationModal').modal('hide');
})
onMounted(() => {
    getCategories();
    getCities();
    $(window).on('load', function() {
        $('#selectLocationModal').modal('show');
    });
})

const getCategories = (() => {
    axios.get('/categories?get=all&status=1').then((response)=>{
        data.categories = response.data.categories;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const chanageLocationType = ((event) => {
    data.locationType = event.target.value;
    console.log(data.locationType);
});
const getCities = (() => {
    axios.get('/cities-has-areas?get=all').then((response)=>{
        data.cities = response.data.cities;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getAreas = (() =>{
    axios.get('/areas-by-city' , {params : {'city_id' : city.value}}).then((response)=>{
        data.areas = response.data.areas;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getBranches = (() =>{
    axios.get('/branches-by-city' , {params : {'city_id' : city.value}}).then((response)=>{
        data.branches = response.data.branches;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getCategoryProducts = (() => {
    axios.get('/category-products' , {params : {'city_id' : city.value , 'branch_id' : branch.value}}).then((response)=>{
        data.categoryProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const selectProduct = ((categoryIndex, productIndex) => {
    data.selectedProduct = data.categoryProducts[categoryIndex].products[productIndex];
    $('#productModal').modal('toggle');
});
const getCategoryName = ((deal) => {
    return data.categories.find((category) => {
        if(category.id === deal.pivot.category_id)
            return category.name;
    }).name
});
const getCategoryDealProducts = ((deal) => {
    let categoryProducts = data.categoryProducts.find((category) => {
        if(category.id === deal.pivot.category_id)
            return category.products;
    })
    return categoryProducts.products;
});
const getNumber = ((i) => {
    let j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
});
const showProduct = ((product) => {
    console.log(city.value , branch.value);
    if(!product.city_id && !product.branch_id)
        return true;
    if(product.city_id && city.value == product.city_id)
        return true;
    if(product.branch_id && branch.value == product.branch_id)
        return true;

    return false;

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
                    <li v-for="(category,index) in data.categories" class="" ><a :href="'#'+category.id">{{category.name}}</a></li>
                </ul>
                <div class="ctg-forward">
                    <img :src="fwd" alt="">
                </div>
            </div>
        </div>
    </section>

    <main>
        <template v-for="(category , categoryIndex) in data.categoryProducts">
            <section v-if="category.products && category.products.length > 0" class="base-section gourmet-fries"   :id="category.id">
                <div class="container-fluid px-container">
                    <h3 class="section-title text-uppercase text-center">{{category.name}}</h3>
                    <div class="row">
                        <template v-for="(product , index) in category.products">
                            <div v-if="showProduct(product)" class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                                <div class="card deal-card" @click="selectProduct(categoryIndex , index)" >
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
                        </template>

                    </div><!-- /.row -->
                </div><!-- /.row -->
            </section>

        </template>

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
		<div class="modal fade" id="selectLocationModal" data-keyboard="false" data-backdrop="static">
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
										<input @change="chanageLocationType($event)" type="radio" class="btn-check" name="regionRadio" id="deleveryRadio" autocomplete="off" checked value="Delivery">
										<label class="btn btn-outline-primary" for="deleveryRadio">Delivery</label>

										<input @change="chanageLocationType($event)" type="radio" class="btn-check" name="regionRadio" id="pickupRadio" autocomplete="off" value="Pickup">
										<label class="btn btn-outline-primary" for="pickupRadio">Pickup</label>
									</div>
								</div>


								<div class="mb-3 select-city">
                                    <TomSelect
                                        v-model="city" :value="city"
                                        :options="{
                                        placeholder: 'Select City',
                                      }"
                                        class="w-full"
                                    >
                                        <option
                                            v-for="(city,index) in data.cities" :key="index" :value="city.id"
                                        >
                                            {{ city.city }}
                                        </option>
                                    </TomSelect>
								</div>


								<div class="mb-3 select-area" v-if="data.locationType === 'Delivery' ">
                                    <TomSelect
                                        v-model="area" :value="area"
                                        :options="{
                                        placeholder: 'Select Area',
                                      }"
                                        class="w-full"
                                    >
                                        <option
                                            v-for="(area,index) in data.areas" :key="index" :value="area.id"
                                        >
                                            {{ area.area }}
                                        </option>
                                    </TomSelect>
								</div>


								<div class="select-branch" v-if="data.locationType === 'Pickup' ">
                                    <TomSelect
                                        v-model="branch" :value="branch"
                                        :options="{
                                        placeholder: 'Select Branch',
                                      }"
                                        class="w-full"
                                    >
                                        <option
                                            v-for="(branch,index) in data.branches" :key="index" :value="branch.id"
                                        >
                                            {{ branch.name }}
                                        </option>
                                    </TomSelect>
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
														<h6 class="text-capitalize">asdasdasd</h6>
														<span>asdasdsad</span>
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
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content p-3">
					<div class="modal-header border-0 d-flex align-items-start">
						<button type="button" class="btn-close border rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body cartModal">
						<div class="row">
							<div class="productSummary col-md-12 col-sm-12" v-if="data.selectedProduct">

								<div class="product-n-review">
									<h4>{{data.selectedProduct.name}}</h4>
                                    <p class="mb-2 bold">Rs. {{data.selectedProduct.price}}</p>
                                    <p class="mb-3">{{data.selectedProduct.description}}</p>
								</div>
                                <div class="text-center">
                                    <Tippy
                                        as="img"
                                        alt="product Image"
                                        class="shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                        :src="data.selectedProduct.image !== null ? '/images/products/'+data.selectedProduct.image : '/images/categories/profile-2.jpg'"
                                        :content="data.selectedProduct.name"
                                    />
                                </div>
								<hr class="hr">
                                <template v-if="data.selectedProduct.type === 'Multiple'" v-for="(deal,dealIndex) in data.selectedProduct.deal_products">
                                    <div class="preferences mb-3" v-if="deal.pivot.quantity > 1" v-for="(n , index) in  deal.pivot.quantity">
                                        <h6>Select Your {{getNumber(n)}} Product Of {{getCategoryName(deal)}}</h6>
                                        <template v-for="(cat_product,index) in getCategoryDealProducts(deal)">
                                            <div class="flex-1 w-full mt-3 xl:mt-0 mb-3" v-if="cat_product.type === 'Single'">
                                                <div class="flex flex-col sm:flex-row">
                                                    <FormCheck class="mr-4">
                                                        <FormCheck.Input
                                                            :id="'deal-product-m1-'+n"
                                                            type="radio"
                                                            :name="'deal-product-m1-'+n"
                                                        />
                                                        <FormCheck.Label :for="'deal-product-m1-'+n">
                                                            <div
                                                                class="w-56 mt-1 text-xs leading-relaxed text-slate-500"
                                                            >{{cat_product.name}}</div>
                                                        </FormCheck.Label>
                                                    </FormCheck>
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <Tippy
                                                            as="img"
                                                            alt="product Image"
                                                            class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                            :src="cat_product.image !== null ? '/images/products/'+cat_product.image : '/images/categories/profile-2.jpg'"
                                                            :content="cat_product.name"
                                                        />
                                                    </div>
                                                </div>
                                                <hr class="hr">
                                            </div>
                                        </template>
                                    </div>
                                    <div class="preferences mb-3" v-else>
                                        <h6>Select Your Product Of {{getCategoryName(deal)}}</h6>
                                        <template v-for="(cat_product,cat_index) in getCategoryDealProducts(deal)">
                                            <div class="flex-1 w-full mt-3 xl:mt-0"  v-if="cat_product.type === 'Single'">
                                                <div class="flex flex-col sm:flex-row">
                                                    <FormCheck class="mr-4">
                                                        <FormCheck.Input
                                                            :id="'deal-product-q1-'+dealIndex"
                                                            type="radio"
                                                            :name="'deal-product-q1-'+dealIndex"
                                                        />
                                                        <FormCheck.Label :for="'deal-product-q1-'+dealIndex">
                                                            <div
                                                                class="w-56 mt-1 text-xs leading-relaxed text-slate-500"
                                                            >{{cat_product.name}}</div>
                                                        </FormCheck.Label>
                                                    </FormCheck>
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <Tippy
                                                            as="img"
                                                            alt="product Image"
                                                            class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                            :src="cat_product.image !== null ? '/images/products/'+cat_product.image : '/images/categories/profile-2.jpg'"
                                                            :content="cat_product.name"
                                                        />
                                                    </div>
                                                </div>
                                                <hr class="hr">
                                            </div>

                                        </template>
                                    </div>
                                </template>
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
