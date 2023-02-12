<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSwitch,
    FormLabel,
} from "../base-components/Form";
import TomSelect from "../base-components/TomSelect";
import Litepicker from "../base-components/Litepicker";
const date = ref("");
const datepickerModalPreview = ref(false);
import Lucide from "../base-components/Lucide";
import Notification from "./Notification.vue";
import {ref, reactive , onMounted, nextTick} from "vue";
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'
import {isset} from "../utils/helper";
import FormSelect from "../base-components/Form/FormSelect.vue";
const router = useRouter()
const route = useRoute()
onMounted(() =>{

    if (route.params.id !== undefined) {
        nextTick().then(() => {
            getProductDetails(route.params.id);
        });
    }
    getAddons();
    getCategories();
    getCities();
    getBranches();
})
let data = reactive({
    product: {
        type:'Single',
        name: '',
        description: '',
        categories: [],
        branch_id: '',
        city_id: '',
        price: 500.00,
        image: null,
        status: true,
        addons: [],
        deal_products:[
            {
                products : [],
                quantity : 1,
            }
        ],
        schedule: {
            start_date : '',
            end_date : '',
            start_time : '',
            end_time : '',
            specific_date : '',
            specific_day : [],
        }
    },
    toastText : '',
    toastType : '',
    addons : [],
    categories : [],
    cities : [],
    branches : [],
    singleProducts : [],
    types : ['Single','Multiple'],
    days : [
        {id:1 , name: 'Monday'} , {id:2 , name: 'Tuesday'} , {id:3 , name: 'Wednesday'} ,
        {id:4 , name: 'Thursday'}, {id:5 , name: 'Friday'}, {id:6 , name: 'Saturday'},{id:7 , name: 'Sunday'}
    ]
});
const types = ref(['Single','Multiple']);
const getAddons = (() => {
    axios.get('/api/addons?get=all' ).then((response) => {
        if (response.data.addons !== undefined){
            data.addons = response.data.addons;
        }

    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getBranches = (() => {
    axios.get('/api/branches?get=all' ).then((response) => {
        if (response.data.branches !== undefined){
            data.branches = response.data.branches;
        }
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});

const getCities = (() => {
    axios.get('/api/cities?get=all' ).then((response) => {
        if (response.data.cities !== undefined){
            data.cities = response.data.cities;
        }

    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getCategories = (() => {
    axios.get('/api/categories?get=all' ).then((response) => {
        if (response.data.categories !== undefined){
            data.categories = response.data.categories;
            (isset(data.categories[0]) && data.product.category_id === '') ? data.product.category_id = data.categories[0].id : '';
        }

    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getProductDetails = ((id) => {
    axios.get('/api/get-product-details/' + id).then((response) => {
        if (response.data.product !== undefined){
            data.product = response.data.product;
            data.product.categories.forEach((value , index) => {
                data.product.categories[index] = value.id.toString();
            });
            data.product.deal_products.forEach((value , index) => {
                data.product.deal_products[index].products = [value.id.toString()];
                data.product.deal_products[index].quantity = value.pivot.quantity;
            });
            if(response.data.product.addons !== null){
                data.product.addons.forEach((value , index) => {
                    data.product.addons[index] = value.id.toString();
                });
            }
            data.product.city_id = data.product.city_id ? data.product.city_id.toString() : '';
            data.product.branch_id = data.product.branch_id ? data.product.branch_id.toString() : '';

            if(data.product.schedule === null){
                data.product.schedule =  {
                    start_date : '',
                    end_date : '',
                    start_time : '',
                    end_time : '',
                    specific_date : '',
                    specific_day : [],
                };

            }
            if(data.product.deal_products.length === 0){
                data.product.deal_products = [
                    {
                        products : [],
                        quantity : 1,
                    }
                ];

            }
        }
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});

const addMoreProducts = (() => {
    let deal_products = data.product.deal_products;
    let lastItem = deal_products.length-1;
    if(deal_products[lastItem].products.length === 0){
        return showNoty('Fill all the details of the las item first', 'error');
    }
    let item = {
        products : [],
        quantity : 1,
    };
    data.product.deal_products.push(item);
});
const saveProduct = (() => {
    axios.post('/api/save-product', data.product).then((response) => {
        showNoty(response.data.message)
        return router.push('/admin/products');
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    })
});
const uploadImage = ((event) => {
    let config = {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    };
    let file = event.target.files[0];
    let formData = new FormData();
    formData.append('image',file);
    formData.append('path',"images/products");
    axios.post("/api/upload-image", formData, config).then((response) => {
        if (response.data.status == 'success') {
            data.product.image = response.data.filename;
        }
        showNoty(response.data.message)
    }).catch( (error) => {
        showNoty(error.response.data.message, 'error')
    });
});
const showNoty = ((message,type = 'success') => {
    data.toastText = message;
    data.toastType = type;
    document.getElementById("toastBtn").click();
});
</script>
<template>
    <Notification :toastText="data.toastText" :toastType="data.toastType" />
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">Add Product</h2>
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
                        Product Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Type</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSelect
                                    v-model="data.product.type" :value="data.product.type"
                                    :options="{
                                        placeholder: 'Select Type',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(type, index) in data.types"
                                        :key="index"
                                        :value="type"
                                    >
                                        {{ type }}
                                    </option>
                                </FormSelect>

                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Categories</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.product.categories" :value="data.product.categories"
                                    :options="{
                                        placeholder: 'Select Categories',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(category, index) in data.categories"
                                        :key="index"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
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
                                    v-model="data.product.name"
                                    :value="data.product.name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Description</div>
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
                                    id="description"
                                    type="text"
                                    placeholder="Description"
                                    v-model="data.product.description"
                                    :value="data.product.description"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Price</div>
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
                                    placeholder="Price"
                                    v-model="data.product.price"
                                    :value="data.product.price"
                                />
                            </div>
                        </FormInline>
                        <FormInline v-if="data.product.type === 'Single'"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Addons</div>
                                    </div>
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        You can choose multiple addons for single product.
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.product.addons"
                                    :value="data.product.addons"
                                    :options="{
                                    placeholder: 'Addons',
                                  }"
                                    class="w-full"
                                    multiple
                                >
                                    <option
                                        v-for="(addon, key) in data.addons"
                                        :key="key"
                                        :value="addon.id"
                                    >
                                        {{ addon.name }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">City</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.product.city_id" :value="data.product.city_id"
                                    :options="{
                                        placeholder: 'Select City',
                                      }"
                                    class="w-full"
                                >
                                    <option value="">Select City</option>
                                    <option
                                        v-for="(city, index) in data.cities"
                                        :key="index"
                                        :value="city.id"
                                    >
                                        {{ city.city }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Branch</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.product.branch_id" :value="data.product.branch_id"
                                    :options="{
                                        placeholder: 'Select Branch',
                                      }"
                                    class="w-full"
                                >
                                    <option value="">Select Branch</option>
                                    <option
                                        v-for="(branch, index) in data.branches"
                                        :key="index"
                                        :value="branch.id"
                                    >
                                        {{ branch.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Status</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        If the product is required, then it must be bought with the product
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSwitch>
                                    <FormSwitch.Input
                                        id="product-status"
                                        type="checkbox"
                                        v-model="data.product.status"
                                        :checked="data.product.status"
                                    />
                                    <FormSwitch.Label htmlFor="category-status-active">
                                        {{data.product.status ? 'Active' : "In Active" }}
                                    </FormSwitch.Label>
                                </FormSwitch>
                            </div>
                        </FormInline>
                        <FormInline class="flex-col items-start mt-10 xl:flex-row">
                            <FormLabel class="w-full xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Image</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div
                                class="flex-1 w-full pt-4 mt-3 border-2 border-dashed rounded-md xl:mt-0 dark:border-darkmode-400"
                            >
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5" v-if="data.product.image !== null">
                                    <div
                                        class="relative col-span-5 cursor-pointer md:col-span-2 h-28 image-fit zoom-in"
                                    >
                                        <img
                                            class="rounded-md"
                                            alt="Avatar"
                                            :src="'/images/products/'+data.product.image"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="relative flex items-center justify-center px-4 pb-4 mt-5 cursor-pointer"
                                >
                                    <Lucide icon="Image" class="w-4 h-4 mr-2" />
                                    <span class="mr-1 text-primary"> Upload a file </span>
                                    or drag and drop
                                    <FormInput
                                        id="horizontal-form-1"
                                        type="file"
                                        class="absolute top-0 left-0 w-full h-full opacity-0"
                                        @change="uploadImage($event)"
                                    />
                                </div>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="p-5 mt-5 intro-y box" v-if="data.product.type==='Multiple'">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Product Categories For Deal
                    </div>
                    <div class="mt-5" v-for="(product,index) in data.product.deal_products">
                        <FormInline
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
                                    v-model="product.products" :value="product.products"
                                    :options="{
                                        placeholder: 'Select Categories',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(category,index) in data.categories"
                                        :key="index"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Quantity</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="quantity"
                                    type="number"
                                    placeholder="Quantity"
                                    v-model="product.quantity"
                                    :value="product.quantity"
                                />
                            </div>
                        </FormInline>

                        <div class="pt-2 mt-2 xl:ml-64 xl:pl-10 first:mt-0 first:pt-0">
                            <Button
                                variant="outline-secondary"
                                class="w-full py-3 border-dashed"
                                @click="addMoreProducts()"
                            >
                                <Lucide icon="Plus" class="w-4 h-4 mr-2" /> Add More Products
                            </Button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-5 mt-5 intro-y box" v-if="data.product.schedule">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Product Schedule
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Start Date</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="data.product.schedule.start_date"
                                        placeholder="Start Date"
                                        :options="{
                                            autoApply: true,
                                            showWeekNumbers: true,
                                            dropdowns: {
                                                minYear: 1990,
                                                maxYear: null,
                                                months: true,
                                                years: true,
                                            },
                                        }"
                                    />
                                </Preview.Panel>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">End Date</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="data.product.schedule.end_date"
                                        :value="data.product.schedule.end_date"
                                        placeholder="End Date"
                                        :options="{
                                            autoApply: true,
                                            showWeekNumbers: true,
                                            dropdowns: {
                                                minYear: 1990,
                                                maxYear: null,
                                                months: true,
                                                years: true,
                                            },
                                        }"
                                    />
                                </Preview.Panel>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Days</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.product.schedule.specific_day" :value="data.product.schedule.specific_day"
                                    :options="{
                                        placeholder: 'Select Days',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(day,index) in data.days"
                                        :key="index"
                                        :value="day.name"
                                    >
                                        {{ day.name }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Start Time</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="start_time"
                                    type="time"
                                    placeholder="start time"
                                    v-model="data.product.schedule.start_time"
                                    :value="data.product.schedule.start_time"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">End Time</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="end_time"
                                    type="time"
                                    placeholder="end time"
                                    v-model="data.product.schedule.end_time"
                                    :value="data.product.schedule.end_time"
                                />
                            </div>
                        </FormInline>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'products' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveProduct()">
                    Save
                </Button>
            </div>
        </div>
    </div>
</template>
