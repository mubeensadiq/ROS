<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSwitch,
    FormLabel,
} from "../base-components/Form";
import TomSelect from "../base-components/TomSelect";
import Notification from "./Notification.vue";
</script>
<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            discount: {
                name: '',
                discount_on : 'OverAll',
                type: 'percentage',
                value: 0,
                status: true,
                discountable: [],

            },
            categories:[],
            products:[],
            branches:[],
            cities:[],
            discounts:['OverAll' , 'Cities' , 'Branches' , 'Categories' , 'Products'],
            toastText : '',
            toastType : 'success',
            update:false
        }
    },
    mounted() {
        this.getCities();
        this.getBranches();
        this.getProducts();
        this.getCategories();
        if (this.$route.params.id !== undefined) {
            this.update = true
            this.$nextTick().then(() => {
                this.getDiscountDetails(this.$route.params.id);
                setTimeout(() => {
                    this.discount.required = this.discount.required === 1 ?  true : false;
                },1000)
            });
        }
    },
    methods: {
        getCities() {
            axios.get('/api/cities?get=all').then((response) => {
                this.cities = response.data.cities;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getBranches() {
            axios.get('/api/branches?get=all' ).then((response) => {
                if (response.data.branches !== undefined){
                    this.branches = response.data.branches;
                }
            }).catch((error) => {
                this.showNoty(error.response.data.message,'error')
            });
        },
        getCategories(){
            axios.get('/api/categories?get=all' ).then((response) => {
                if (response.data.categories !== undefined){
                    this.categories = response.data.categories;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message,'error')
            });
        },
        getProducts(){
            axios.get('/api/products?get=all' ).then((response) => {
                if (response.data.products !== undefined){
                    this.products = response.data.products;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message,'error')
            });
        },
        getDiscountDetails(id) {
            axios.get('/api/get-discount-details/' + id).then((response) => {
                if (response.data.discount !== undefined){
                    this.discount = response.data.discount;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message,'error')
            });
        },
        saveDiscount() {
            axios.post('/api/save-discount', this.discount).then((response) => {
                this.showNoty(response.data.message)
                return this.$router.push('/admin/discounts');
            }).catch((error) => {
                this.showNoty(error.response.data.message,'error')
            })
        },
        showNoty(message,type = 'success'){
            this.toastText = message;
            this.toastType = type;
            document.getElementById("toastBtn").click();
        }
    }
}
</script>
<template>
    <Notification :toastText="toastText" :toastType="toastType" />
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">{{update ? "Update Discount" : "Add New Discount"}}</h2>
    </div>
    <div class="grid grid-cols-11 pb-20 mt-5 gap-x-6">
        <!-- BEGIN: Notification -->
        <!-- BEGIN: Notification -->
        <div class="col-span-11 intro-y 2xl:col-span-9">

            <!-- BEGIN: Product Information -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Discount
                        Information
                    </div>
                    <div class="mt-5">

                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Name</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="name"
                                    type="text"
                                    placeholder="Name"
                                    v-model="discount.name"
                                    :value="discount.name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Discount Type</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.type" :value="discount.type"
                                    :options="{
                                        placeholder: 'Select Discount Type',
                                      }"
                                    class="w-full"
                                >
                                    <option value="percentage">Percentage</option>
                                    <option value="price">Price</option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Value</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="price"
                                    type="text"
                                    placeholder="Value"
                                    v-model="discount.value"
                                    :value="discount.value"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Discount Applied On</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.discount_on" :value="discount.discount_on"
                                    :options="{
                                        placeholder: 'Select Discount Applied On',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(disc, index) in discounts"
                                        :key="index"
                                        :value="disc"
                                    >
                                        {{ disc }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline v-if="discount.discount_on === 'Categories'"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Categories</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.discountable" :value="discount.discountable"
                                    :options="{
                                        placeholder: 'Select Categories',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(category, index) in categories"
                                        :key="index"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline v-if="discount.discount_on === 'Products'"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Products</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.discountable" :value="discount.discountable"
                                    :options="{
                                        placeholder: 'Select Products',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(product, index) in products"
                                        :key="index"
                                        :value="product.id"
                                    >
                                        {{ product.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline v-if="discount.discount_on === 'Cities'"
                                    class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Cities</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.discountable" :value="discount.discountable"
                                    :options="{
                                        placeholder: 'Select Cities',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(city, index) in cities"
                                        :key="index"
                                        :value="city.id"
                                    >
                                        {{ city.city }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline v-if="discount.discount_on === 'Branches'"
                                    class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Branches</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="discount.discountable" :value="discount.discountable"
                                    :options="{
                                        placeholder: 'Select Branches',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(branch, index) in branches"
                                        :key="index"
                                        :value="branch.id"
                                    >
                                        {{ branch.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'discounts' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveDiscount()">
                    {{ update ? "Update" : "Save" }}
                </Button>
            </div>
        </div>
    </div>
</template>
