<style scoped>
@import "../../../public/css/frontend.css";
</style>

<script setup lang="ts">
import bg1 from "../../../public/images/assets/bg1.png";
import logo from "../../../public/images/assets/logo.png";
import facebook from "../../../public/images/assets/facebook.png";
import youtube from "../../../public/images/assets/youtube.png";
import googlePlus from "../../../public/images/assets/google-plus.png";
import deal1 from "../../../public/images/assets/deal-1.png";
import twitter from "../../../public/images/assets/twitter.png";
import cash from "../../../public/images/assets/cash.png";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";
import {onMounted, reactive} from "vue";
import axios from "axios";
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()
const data = reactive({
    cart : [],
    delivery_charges: 0,
    info:{
        first_name: '',
        last_name: '',
        email:'',
        phone_number:'',
        alternate_phone:'',
        delivery_address: '',
        landmark:'',
        instructions: '',
        city: localStorage.getItem('city') ?? 0,
        area: localStorage.getItem('area') ?? null,
        branch: localStorage.getItem('branch') ?? null
    },
    validateError:{
        first_name: {
            message : 'Please enter your first name',
            error:false
        },
        last_name: {
            message : 'Please enter your last name',
            error:false
        },
        phone_number:{
            message : 'Please enter your phone number',
            error:false
        },
        delivery_address: {
            message : 'Please enter delivery address',
            error:false
        },
        email:{
            message : 'Invalid Email Address',
            error:false
        },
    }
});
onMounted( () => {
    getDeliveryCharges();
    let cart = localStorage.getItem('cart');
    if(cart)
        data.cart = JSON.parse(cart);
})
const getDeliveryCharges =(() => {
    axios.get('/area-details/'+localStorage.getItem('area') ?? 0).then((response) => {
        if(response.data.status == 'success' && response.data.area != undefined){
            data.delivery_charges = response.data.area.delivery_charges;
        }
    })
});
const placeOrder = (() => {
   const validate = validateFields();
   if(validate){
       axios.post('/api/save-order' , {'customer' : data.info , 'cart' : data.cart , 'delivery_charges' : data.delivery_charges}).then((response) => {
            if(response.data.status == 'success'){
                localStorage.setItem('order', JSON.stringify(response.data.order));
                localStorage.removeItem('cart');
                router.push('/confirm');
            }
       })
   }
});
const validateFields = (()=>{
    const required_fields = ['first_name','last_name','phone_number','delivery_address'];
    let validateFields = true;
    required_fields.forEach((field) => {
        data.validateError[field].error = false;
        if(data.info[field] == ""){
            data.validateError[field].error = true;
            validateFields = false;
        }
    })
    if(!validateFields)
        return false;
    if(data.info.email != ""){
        const validEmail = validateEmail();
        if(!validEmail)
            return false;
    }

    return true;

});
const validateEmail = (() => {
    return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(data.info.email);
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
                                <input type="text" class="form-control" id="inputFirstName" placeholder="Enter your first name" required v-model="data.info.first_name">
                                <span class="text-danger" v-if="data.validateError.first_name.error">{{data.validateError.first_name.message}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">Last Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputLastName" placeholder="Enter your last name" required v-model="data.info.last_name">
                                <span class="text-danger" v-if="data.validateError.last_name.error">{{data.validateError.last_name.message}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPhone" class="form-label">Phone Number <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputPhone" required placeholder="Enter Your Phone Number" v-model="data.info.phone_number">
                                <span class="text-danger" v-if="data.validateError.phone_number.error">{{data.validateError.phone_number.message}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAlternativeNumber" class="form-label">Alternate Number</label>
                                <input type="text" class="form-control" id="inputAlternativeNumber" placeholder="Enter Your Alternate Phone Number" v-model="data.info.alternate_phone">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Delivery Address <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="Enter your complete address" required v-model="data.info.delivery_address">
                                <span class="text-danger" v-if="data.validateError.delivery_address.error">{{data.validateError.delivery_address.message}}</span>
                            </div>
                            <div class="col-12">
                                <label for="inputInstructions" class="form-label">Delivery Instructions</label>
                                <input type="text" class="form-control" id="inputInstructions" placeholder="Enter any instruction or note to rider" v-model="data.info.instructions">
                            </div>
                            <div class="col-md-6">
                                <label for="inputLandmark" class="form-label">Nearest Landmark</label>
                                <input type="text" class="form-control" id="inputLandmark" placeholder="Any famous place nearby" v-model="data.info.landmark">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="inputEmail" placeholder="Please enter your email" v-model="data.info.email">
                                <span class="text-danger" v-if="data.validateError.email.error">{{data.validateError.email.message}}</span>
                            </div>
                            <div class="col-12">
                                <h6 class="text-capitalize">PAYMENT INFORMATION</h6>

                                <div class="payment-selector mt-4 d-flex">
                                    <div class="cash col-sm-4 d-flex flex-column justify-content-center align-items-center">
                                        <img name="onCash" class="img img-responsive" :src="cash" alt="">
                                        <label for="onCash">Cash</label>
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
                            <div class="order-list d-flex align-items-center mb-3" v-for="(cart,index) in data.cart.items">
                                <div class="order-image d-flex col-3">
                                    <img class="img" :src="cart.image !== null ? '/images/products/'+cart.image : deal1" alt="">
                                    <hr class="order-image-separator">
                                </div>
                                <div class="order-item d-flex justify-content-between align-items-center col-9">
                                    <div class="item-name px-3 col-10">
                                        <h6 class="text-capitalize">{{cart.quantity}} x {{cart.name}}</h6>
                                        <template v-for="addon in cart.addons">
                                            <p v-if="addon" class="mb-0">
                                                <template v-if="Array.isArray(addon)">
                                                    <span v-for="item in addon">{{item.quantity}} x {{item.name}} <span v-if="item.price > 0">Rs({{item.price}})</span> <br/></span>
                                                </template>
                                                <template v-else>
                                                    {{addon.name}} <span v-if="addon.price > 0">Rs({{addon.price}})</span>
                                                </template>
                                            </p>
                                        </template>
                                    </div>
                                    <p class="item-value mb-0 col-2">Rs. {{ cart.price * cart.quantity }}</p>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="order-summary d-flex justify-content-between">
                                <div class="summary-labels">
                                    <p>Subtotal</p>
                                    <p>Tax</p>
                                    <p class="mb-0">Delivery Fee</p>
                                </div>
                                <div class="summary-values text-right">
                                    <p>Rs. {{data.cart.subTotal}}</p>
                                    <p>Rs. {{data.cart.tax_amount}}</p>
                                    <p class="mb-0">Rs. {{ data.delivery_charges }}</p>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="order-total d-flex justify-content-between">
                                <label for="">Total</label>
                                <span>{{data.cart.subTotal + data.cart.tax_amount + data.delivery_charges}}</span>
                            </div>
                            <div class="order-voucher mt-3">
                                <label>Voucher</label>
                                <div class="voucher-input d-flex justify-content-between">
                                    <input type="text" class="mr-2" placeholder="Enter Voucher here">
                                    <button class="btn btn-warning">Apply</button>
                                </div>
                            </div>

                            <button class="btn btn-warning btn-submit mt-3" @click="placeOrder()">Place Order</button>
                            <router-link :to="{name : 'Home'}" class="btn btn-warning mt-3">Continue Shopping</router-link>
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


