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
import Notification from "./Notification.vue";
import {onMounted, reactive, ref, watch, onBeforeUnmount} from "vue";
import TomSelect from "../base-components/TomSelect";
import {FormCheck,} from "../base-components/Form";
import axios from "axios";
import Tippy from "../base-components/Tippy";


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


const data = reactive({
    cities: [],
    areas: [],
    branches: [],
    categories: [],
    cart:{
        items:[],
        tax_amount : 0.00,
        subTotal: 0.00
    },
    temporaryItem:{ },
    discount : {},
    categoryProducts: [],
    selectedProduct : null,
    locationType: 'Delivery',
    toastText: '',
    toastType: 'success',
    tax_amount : 0,
    tax : 0.00,
    subTotal : 0.00,
    tax_type : '',
    taxApplicable: false
})
const city = ref(localStorage.getItem('city') ?? '');
const area = ref(localStorage.getItem('area') ?? '');
const branch = ref(localStorage.getItem('branch') ?? '');
watch(city, async (newCity) => {
    localStorage.setItem('city' , city.value)
    getAreas();
    getBranches();
})
watch(area, async(val) => {
    localStorage.setItem('area' , area.value)
    $('#selectLocationModal').modal('hide');
})
watch(branch, async(val) => {
    localStorage.setItem('branch' , branch.value)
    getCategoryProducts();
    $('#selectLocationModal').modal('hide');
})
onMounted(() => {
    getCategories();
    getCities();
    getCategoryProducts();
    getDiscount();
    let cart = localStorage.getItem('cart');
    if(cart)
        data.cart = JSON.parse(cart);
    $(window).on('load', function() {
        if(localStorage.getItem('city') === null)
            $('#selectLocationModal').modal('show');
    });
});
onBeforeUnmount(() => {
    $('#shoppingCartModal').modal('toggle');
});
const getCategories = (() => {
    axios.get('/categories?get=all&status=1').then((response)=>{
        data.categories = response.data.categories;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const chanageLocationType = ((event) => {
    data.locationType = event.target.value;
});
const getCities = (() => {
    axios.get('/cities-has-areas?get=all').then((response)=>{
        data.cities = response.data.cities;
        taxApplicable();
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
const getDiscount = (() =>{
    axios.get('/discount').then((response)=>{
        data.discount = response.data.discount;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const getCategoryProducts = (() => {
    axios.get('/category-products' , {params : {'area_id' : area.value , 'branch_id' : branch.value}}).then((response)=>{
        data.categoryProducts = response.data.products;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
});
const selectProduct = ((categoryIndex, productIndex) => {
    data.selectedProduct = data.categoryProducts[categoryIndex].products[productIndex];
    data.temporaryItem.id = data.categoryProducts[categoryIndex].products[productIndex].id;
    data.temporaryItem.name = data.categoryProducts[categoryIndex].products[productIndex].name;
    data.temporaryItem.price = data.categoryProducts[categoryIndex].products[productIndex].price;
    data.temporaryItem.image = data.categoryProducts[categoryIndex].products[productIndex].image;
    data.temporaryItem.tax_applicable = data.categoryProducts[categoryIndex].products[productIndex].tax_applicable;
    data.temporaryItem.addons = [];
    if(hasDiscount(data.temporaryItem)){
        data.temporaryItem.price = getDiscountedPrice(data.temporaryItem);
    }
    $('#productModal').modal('toggle');
});
const addIntoItem = ((addon,cat_index,type,quantity,index) => {
    addon.quantity = quantity
    if(type === 'single'){
        data.temporaryItem.addons[cat_index] = addon;
        data.temporaryItem.addons[cat_index].quantity = quantity;
    }
    else{
        let addonQtyElement = $('#addon-qty'+cat_index+'-'+addon.id);
        let addonQtyVal = parseInt(addonQtyElement.val());
        if(addonQtyVal > quantity)
            addonQtyElement.val(quantity);

        addon.quantity = parseInt(addonQtyElement.val());
        if(data.temporaryItem.addons[cat_index] !== undefined){
            if($('#deal-product-' +cat_index+index).is(":checked"))
                data.temporaryItem.addons[cat_index].push(addon);
            else
                data.temporaryItem.addons[cat_index].pop(addon);
        }
        else
            data.temporaryItem.addons[cat_index] = [addon];
    }
});
const manageAddonCounter = ((index , addon , type) => {

    let tempAddon =  data.temporaryItem.addons[index];
    let addonQtyElement = $('#addon-qty'+index+'-'+addon.id);
    let addonQtyVal = parseInt(addonQtyElement.val());
    if(type === 'minus' && addonQtyVal > 1){
        addonQtyVal -= 1;
        addonQtyElement.val(addonQtyVal);
    }
    if(type === 'add'){
        addonQtyVal += 1;
        addonQtyElement.val(addonQtyVal);
    }
    if(tempAddon !== undefined){
        tempAddon.find((add , index) => {
            if(addon.id === add.id){
                addon.quantity = addonQtyVal;
            }
        })
    }
});
const getQuantity = ((index) => {
    let tempAddon =  data.temporaryItem.addons[index];
    let quantity = 0;
    tempAddon.forEach((addon) => {
       quantity += addon.quantity;
        if(addon.price > 0){
            data.temporaryItem.price += addon.price*addon.quantity;
        }
    });
    return quantity;
});
const manageProductCounter = ((type) => {

    let productQtyElement = $('#product-quantity');
    let productQtyVal = parseInt(productQtyElement.val());
    if(type === 'minus' && productQtyVal > 1){
        productQtyVal -= 1;
        productQtyElement.val(productQtyVal);
    }
    if(type === 'add'){
        productQtyVal += 1;
        productQtyElement.val(productQtyVal);
    }
});
const addToCart = ( async() => {
    let validateCart = true;
    let message = "";
    await data.selectedProduct.addon_category_product.forEach((addon , index) => {
        let item = data.temporaryItem.addons[index];
        if(addon.required && item == undefined ){
            message = addon.category.title + " is required";
            validateCart = false;
            return;
        }
        if(addon.quantity > 1){
            if(item !== undefined){
                if(item.length == 0){
                    message = addon.category.title + " is required";
                    validateCart = false;
                    return;
                }
                let addedQuantity =  getQuantity(index);
                if(addedQuantity !== addon.quantity){
                    message = "Please check the quantity of " + addon.category.title;
                    validateCart = false;
                    return;
                }
            }
        }
        if(addon.quantity == 1 && item && item.price > 0){
            data.temporaryItem.price += item.price;
        }
    })
    if(!validateCart){
        showNoty(message,'error');
    }
    if(validateCart){
        let productQtyElement = $('#product-quantity');

        data.temporaryItem.quantity = parseInt(productQtyElement.val());
        data.cart.items.push(data.temporaryItem);
        data.cart.subTotal = getTotal();
        data.cart.tax_amount = getTax();
        localStorage.setItem('cart' , JSON.stringify(data.cart))
        data.temporaryItem = {};

        data.selectedProduct = null;
        $('#productModal').modal('toggle');
    }

});
const removeItem = ((index) => {
    data.cart.items.splice(index , 1);
    data.cart.subTotal = getTotal();
    data.cart.tax_amount = getTax();
    localStorage.setItem('cart' , JSON.stringify(data.cart))

});
const updateCart = (() => {
    data.cart.items.forEach((cart , index) => {
        let productQtyElement = $('#cart-quantity-'+index);
        cart.quantity = parseInt(productQtyElement.val());
    })
    data.cart.subTotal = getTotal();
    data.cart.tax_amount = getTax();
    localStorage.setItem('cart' , JSON.stringify(data.cart))
});
const getTotal = (() => {
    let price = 0.00;
    data.cart.items.forEach((cart , index) => {
        price += cart.price*cart.quantity
    });
    return Number(price.toFixed(2));
});
const updateQuantity = (() => {
    let productQtyElement = $('#product-quantity');
    let value = parseInt(productQtyElement.val());
    if(value < 1)
        productQtyElement.val(1);
});
const taxApplicable = (() => {
    const city_id = localStorage.getItem('city');
    data.cities.find((city , index) => {
        if(city.id == city_id){
            data.tax_amount = city.tax_amount;
            data.tax_type = city.tax_type;
            data.taxApplicable = true;
            return true;
        }
    });
})

const getTax = (() => {
    let taxPrice = 0.00;
    if(data.taxApplicable){
        data.cart.items.forEach((cart , index) => {
            if(cart.tax_applicable == 1){
                if(data.tax_type == 'Inclusive Tax'){
                    const discount = ((cart.price/100)*data.tax_amount).toFixed(2);
                    taxPrice += Number(discount);
                }
            }
        });
    }

    return  Number(taxPrice.toFixed(2));
})
const getDiscountedPrice = ((product) => {
    let price = product.price;
    if(data.discount){
        if(data.discount.type == "percentage"){
            price = price - ((price/100))*data.discount.value;
        }
        else{
            price = price - data.discount.value;
        }
    }
    return price;
});
const hasDiscount = ((product) => {
    let discount = false;
    if(data.discount){
        if(data.discount.discount_on === 'OverAll'){
            discount = true;
            return true;
        }
        if(data.discount.discount_on === 'Products'){
            data.discount.products.forEach((discount_product , index) => {
                if(product.id == discount_product.id){
                    discount = true;
                    return true;
                }

            });
        }
        if(data.discount.discount_on === 'Categories'){
            data.discount.categories.forEach((discount_category , index) => {
                product.categories.forEach((category ,cat_index) => {
                    if(category.id == discount_category.id){
                        discount = true;
                        return true;
                    }
                })
            });
        }
        if(data.discount.discount_on === 'Cities'){
            data.discount.cities.forEach((discount_cities , index) => {
                if(localStorage.getItem('city') == discount_cities.id){
                    discount = true;
                    return true;
                }

            });
        }
    }
    return discount;
});
const showCartModal = (() => {
    $('#shoppingCartModal').modal('toggle');
})
const showNoty = ((message,type = 'success') => {
    data.toastText = message;
    data.toastType = type;
    document.getElementById("toastBtn").click();
});
</script>

<template>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://getbootstrap.com/docs/5.3/examples/carousel/carousel.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="https://getbootstrap.com/docs/5.3/assets/img/favicons/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600' rel='stylesheet' as="style" type='text/css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
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
				<div class="shopping-icon" @click="showCartModal()">
					<span class="badge bg-dark rounded-circle p-2">{{data.cart.items.length}}</span>
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
        <Notification :toastText="data.toastText" :toastType="data.toastType" />
        <template v-for="(category , categoryIndex) in data.categoryProducts">
            <section v-if="category.products && category.products.length > 0" class="base-section gourmet-fries"   :id="category.id">
                <div class="container px-container">
                    <h3 class="section-title text-uppercase text-center">{{category.name}}</h3>
                    <div class="row">
                        <template v-for="(product , index) in category.products">
                            <div class="col-lg-3 col-md-6 col-xs-12 mb-5 d-flex justify-content-center">
                                <div class="card deal-card" @click="selectProduct(categoryIndex , index)" >
                                    <div class="card-image"><img class="card-img-top" :src="'/images/products/'+product.image" alt="Card image cap"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{product.name}}</h5>
                                        <p class="card-text">{{product.description}} </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="price-label" v-if="hasDiscount(product)">Rs. <s class="price-label-strike">{{product.price}}</s> {{getDiscountedPrice(product)}}</label>
                                            <label class="price-label" v-else>Rs. {{product.price}}</label>
                                            <img :src="cartIcon" alt="">
                                        </div>
                                    </div>
                                    <div class="discount-tag" v-if="hasDiscount(product)">
                                        <label v-if="data.discount.type === 'percentage'">{{data.discount.value}}%<br><span>OFF</span></label>
                                        <label v-if="data.discount.type === 'price'" class="price-tag">Rs. {{data.discount.value}}<br><span>OFF</span></label>
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
		<div class="modal fade" id="selectLocationModal" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-md modal-dialog-centered">
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
                                        class="w-full bg-transparent"
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
                                        class="w-full bg-transparent"
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
		<div class="modal fade" id="shoppingCartModal"  data-bs-backdrop="static" >
			<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content p-3 border-r-20">
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
										<th scope="col" style="width:15%">Price</th>
										<th scope="col">Quantity</th>
										<th scope="col">Subtotal</th>
										<th scope="col"></th>
									</tr>
									</thead>
									<tbody class="cart-body">
										<tr v-for="(cart,index) in data.cart.items">
											<td>
												<div class="order-image d-flex">
													<img class="img" :src="cart.image !== null ? '/images/products/'+cart.image : '/images/categories/profile-2.jpg'" alt="">
													<hr class="order-image-separator">
												</div>
											</td>
											<td>
												<div class="order-item d-flex justify-content-between align-items-center w-100">
													<div class="item-name">
														<h6 class="text-capitalize">{{cart.name}}</h6>
														<p v-for="addon in cart.addons">
                                                            <template v-if="addon">
                                                                <template v-if="Array.isArray(addon)">
                                                                    <span v-for="item in addon">{{item.quantity}} x {{item.name}} <span v-if="item.price > 0">Rs({{item.price}})</span> <br/></span>
                                                                </template>
                                                                <template v-else>
                                                                    {{addon.name}} <span v-if="addon.price > 0">Rs({{addon.price}})</span>
                                                                </template>
                                                            </template>


                                                        </p>
													</div>

												</div>
											</td>
											<td>
                                                <p class="item-value mb-0">Rs. {{cart.price}}</p>
                                            </td>
											<td style="width:15%;"><input type="number" class="w-100" placeholder="0" :min="1" v-model="cart.quantity" :id="'cart-quantity-'+index" /></td>
											<td>
                                                <p class="item-value mb-0">Rs. {{ cart.price * cart.quantity }}</p>
                                            </td>
											<td @click="removeItem(index)"><a href="#"><img class="img remove-item" :src="deleteIcon" alt=""></a></td>
                                        </tr>
                                    </tbody>
								</table>
                                <button class="btn btn-yellow float-end" @click="updateCart()">Update cart</button>
							</div>
							<div class="col-md-4 col-sm-12">
								<div class="cart-total px-3 py-4">
									<div class="cart-summary">
										<h6>Cart Totals</h6>
										<div class="order-total d-flex justify-content-between mt-5">
											<p class="total-label">Subtotal</p>
											<span class="text-dark">Rs. {{ data.cart.subTotal}}.00</span>
										</div>
                                        <div class="order-total d-flex justify-content-between mt-2" v-if="data.taxApplicable">
                                            <p class="total-label">Tax</p>
                                            <span class="text-dark">Rs. {{ data.cart.tax_amount }}</span>
                                        </div>
										<hr class="hr">
										<div class="order-total d-flex justify-content-between mt-3">
											<p class="total-label">Total</p>
											<span>Rs. {{ data.cart.subTotal + data.cart.tax_amount }}</span>
										</div>
									</div>
									<div class="proceed-cart text-center mt-3">
										<router-link :to="{name : 'Checkout'}" class="btn btn-yellow">Proceed to checkout</router-link>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Product Modal -->
		<div class="modal in" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content p-3" v-if="data.selectedProduct">
                    <div class="outside-close">
                        <button type="button" class="close" data-bs-dismiss="modal">
                            <span style="display: none;">Close</span>×</button>
                    </div>
                    <div class="modal-header">
                        <h4>{{data.selectedProduct.name}} </h4>
                    </div>
					<div class="modal-body cartModal">
						<div class="row">
							<div class="productSummary col-md-12 col-sm-12">

								<div class="product-n-review">

                                    <p class="mb-2 bold price-label">Rs. {{data.selectedProduct.price}}</p>
                                    <p class="mb-3">{{data.selectedProduct.description}}</p>
								</div>
                                <div class="p-2">
                                    <Tippy
                                        as="img"
                                        alt="product Image"
                                        class="w-100"
                                        :src="data.selectedProduct.image !== null ? '/images/products/'+data.selectedProduct.image : '/images/categories/profile-2.jpg'"
                                        :content="data.selectedProduct.name"
                                    />
                                </div>
								<hr class="hr">
                                <template v-for="(cat_product,a_c_p_index) in data.selectedProduct.addon_category_product">
                                    <div class="preferences mb-3" v-if="cat_product.addons.length > 0">
                                        <h6 class="addon-cat-title">{{cat_product.category.title}}<span v-if="cat_product.required" class="required-label">Required</span></h6>
                                        <template v-for="(addon,index) in cat_product.addons">
                                            <div class="flex-1 w-full mt-3 xl:mt-0 mb-3">
                                                <div class="flex flex-col sm:flex-row cart-counter">
                                                    <FormCheck class="w-50" v-if="cat_product.quantity === 1">
                                                        <FormCheck.Input
                                                            :id="'deal-product-'+a_c_p_index+index"
                                                            type="radio"
                                                            :name="'deal-product-'+a_c_p_index"
                                                            :value="addon.id"
                                                            @change="addIntoItem(addon, a_c_p_index , 'single',cat_product.quantity,index)"
                                                        />
                                                        <FormCheck.Label :for="'deal-product-'+a_c_p_index+index">
                                                            <div
                                                                class="text-md leading-relaxed text-slate-500"
                                                            >{{addon.name}}</div>
                                                        </FormCheck.Label>

                                                    </FormCheck>
                                                    <FormCheck class="w-50" v-if="cat_product.quantity > 1">
                                                        <FormCheck.Input
                                                            :id="'deal-product-'+a_c_p_index+index"
                                                            type="checkbox"
                                                            :name="'deal-product-'+a_c_p_index"
                                                            :value="addon.id"
                                                            @change="addIntoItem(addon, a_c_p_index , 'multiple',cat_product.quantity,index)"
                                                        />
                                                        <FormCheck.Label :for="'deal-product-'+a_c_p_index+index">
                                                            <div
                                                                class="text-md leading-relaxed text-slate-500"
                                                            >{{addon.name}}</div>
                                                        </FormCheck.Label>

                                                    </FormCheck>

                                                    <div  :class="addon.image ? 'w-15 addon-image image-fit zoom-in' : 'w-15 addon-image' ">
                                                        <Tippy v-if="addon.image"
                                                            as="img"
                                                            alt="product Image"
                                                            :src="addon.image !== null ? '/images/addons/'+addon.image : '/images/categories/profile-2.jpg'"
                                                            :content="addon.name"
                                                        />
                                                    </div>
                                                    <div v-if="cat_product.quantity > 1" class="w-25 counter d-inline-flex mr-5">
                                                        <button type="button" class="sober-icon-box btn btn-secondary" @click="manageAddonCounter(a_c_p_index,addon , 'minus')">
                                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="minus" class="svg-inline--fa fa-minus " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 288h-352c-17.69 0-32-14.32-32-32.01s14.31-31.99 32-31.99h352c17.69 0 32 14.3 32 31.99S417.7 288 400 288z"></path></svg>
                                                        </button>
                                                        <input type="tel" class="quantity-box form-control" value="1" :id="'addon-qty'+a_c_p_index+'-'+addon.id" @blur="changeAddonQuantity(a_c_p_index,addon)">
                                                        <button type="button" class="sober-icon-box btn btn-secondary" @click="manageAddonCounter(a_c_p_index,addon , 'add')">
                                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"></path></svg>
                                                        </button>
                                                    </div>

                                                    <div class="w-35">
                                                        <span class="addon-price" v-if="addon.price > 0">Rs {{addon.price}}</span>
                                                    </div>
                                                </div>
                                                <hr class="hr">
                                            </div>
                                        </template>
                                    </div>
                                </template>

							</div>
						</div>
					</div>
                    <div class="modal-footer">
                        <div class="flex-1 w-full mt-3 xl:mt-0 mb-3">
                            <div class="flex flex-col sm:flex-row cart-counter">
                                <div class="w-25 counter d-inline-flex mr-5">
                                    <button type="button" class="sober-icon-box btn btn-secondary" @click="manageProductCounter('minus')">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="minus" class="svg-inline--fa fa-minus " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 288h-352c-17.69 0-32-14.32-32-32.01s14.31-31.99 32-31.99h352c17.69 0 32 14.3 32 31.99S417.7 288 400 288z"></path></svg>
                                    </button>
                                    <input type="tel" class="quantity-box form-control" value="1" id="product-quantity" @blur="updateQuantity()">
                                    <button type="button" class="sober-icon-box btn btn-secondary" @click="manageProductCounter('add')">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"></path></svg>
                                    </button>
                                </div>
                                <div class="cart-count w-75" @click="addToCart()">
                                    <div class="d-flex m-0 justify-content-center">
                                        <div class="add-to-cart text-center">Add To Cart
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
				</div>
			</div>
		</div>
    </main>
</template>
