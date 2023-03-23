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
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.min.js";
import "https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js";
import "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js";
import {onMounted, reactive} from "vue";
import axios from "axios";
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()
const data = reactive({
    order : null,
});
onMounted( () => {
    let order = localStorage.getItem('order');
    if(order){
        data.order = JSON.parse(order);
        axios.get('/order-details/'+data.order.id).then((response) => {
            if(response.data.order !== undefined){
                data.order = response.data.order;
            }
        })
    }

})

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
                    <h2 class="text-uppercase">ORDER INFORMATION</h2>
                </div>
            </div>
        </div>
    </section>
    <main>
        <div class="row py-5 justify-content-center">
            <div class="col-6 text-center">
                <section id="checkoutForm" v-if="data.order">
                    <div class="container-fluid">

                        <div class="billing-details py-5">
                            <p class="your-order">Your Order is</p>
                            <span class="order-status text-uppercase">{{data.order.status}}</span>
                            <img :src="confirmation" alt="" class="order-image">
                            <p class="order-number">Order Number: <span>{{data.order.order_number}}</span></p>
                            <p class="order-text">Your order has been received. we might call you for confirmation or
                                address details if required.</p>
                        </div>
                    </div>
                </section>
            </div><!-- /.row -->
        </div><!-- /.row -->


        <!-- FOOTER -->
        <footer class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="social-icons mb-3 d-inline-flex">
                <img :src="facebook" alt="facebook icon">
                <img :src="googlePlus" alt="google icon">
                <img :src="twitter" alt="twitter icon">
                <img :src="youtube" alt="youtube icon">
            </div>
            <p class="mb-0">Copyright &copy; 2023 <span class="color-1">Fastburger</span>. All Rights Reserved.</p>
        </footer>
    </main>


</template>


