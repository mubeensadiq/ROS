<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormSelect,
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
const router = useRouter()
const route = useRoute()
onMounted(() =>{
    getAddonCategories();
    getCategories();
    getCities();
    getBranches();
    if (route.params.id !== undefined) {
        nextTick().then(() => {
            getProductDetails(route.params.id);
        });
    }

})
let data = reactive({
    product: {
        type:'Single',
        name: '',
        description: '',
        categories: [],
        branch_product: [
            {
                branches : [],
                price: 0
            }
        ],
        price: 500.00,
        image: null,
        status: true,
        addons: [],
        addon_category_product:[
            {
                addonCategory : '',
                addons:[],
                quantity : 1,
                required : false,
                categoryAddons:[]
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
    categories : [],
    addonCategories : [],
    cities : [],
    branches : [],
    singleProducts : [],
    types : ['Single','Deal'],
    days : [
        {id:1 , name: 'Monday'} , {id:2 , name: 'Tuesday'} , {id:3 , name: 'Wednesday'} ,
        {id:4 , name: 'Thursday'}, {id:5 , name: 'Friday'}, {id:6 , name: 'Saturday'},{id:7 , name: 'Sunday'}
    ]
});
const types = ref(['Single','Deal']);

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
        }

    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getAddonCategories = (() => {
    axios.get('/api/addon-categories?get=all' ).then((response) => {
        if (response.data.categories !== undefined){
            data.addonCategories = response.data.categories;
            if(!route.params.id){
                data.product.addon_category_product[0].addonCategory = data.addonCategories[0].id.toString();
                getCategoryAddons(0);
            }
        }
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getCategoryAddons = ((p_a_index) => {;
    data.product.addon_category_product[p_a_index].categoryAddons =  data.addonCategories.find((category) => {
       if(category.id == data.product.addon_category_product[p_a_index].addonCategory)
           return category;
    }).addons;
});
const getProductDetails = ((id) => {
    axios.get('/api/get-product-details/' + id).then((response) => {
        if (response.data.product !== undefined){
            data.product = response.data.product;
            data.product.categories.forEach((value , index) => {
                data.product.categories[index] = value.id.toString();
            });
            data.product.branch_product.forEach((value , index) => {
                data.product.branch_product[index].branches = [value.id.toString()];
                data.product.branch_product[index].price = value.pivot.price;
            });
            data.product.addon_category_product.forEach((value , index) => {
                data.product.addon_category_product[index].addonCategory = value.addon_category_id;
                data.product.addon_category_product[index].quantity = value.quantity;
                data.product.addon_category_product[index].required = value.required === 1 ? true : false;
                data.product.addon_category_product[index].addons = value.addons;

                data.product.addon_category_product[index].addons.forEach((addon, a_index) => {
                    data.product.addon_category_product[index].addons[a_index] = addon.id.toString();
                })
                console.log(data.addonCategories.find((category) => {
                    if(category.id == data.product.addon_category_product[index].addonCategory)
                        return category;
                }));
                data.product.addon_category_product[index].categoryAddons =  data.addonCategories.find((category) => {
                    if(category.id == data.product.addon_category_product[index].addonCategory)
                        return category;
                }).addons;

            });

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
            if(data.product.addon_category_product.length === 0){
                data.product.addon_category_product = [
                    {
                        addonCategory : '',
                        products:[],
                        quantity : 1,
                        required: false,
                        categoryAddons:[]
                    }
                ];

            }
            if(data.product.branch_product.length === 0){
                data.product.branch_product = [
                    {
                        branches : [],
                        price: 0
                    }
                ];

            }
        }
    }).catch((error) => {
        console.log(error);
        showNoty(error.response.data.message,'error')
    });
});

const addMoreProducts = (() => {
    let addon_category_product = data.product.addon_category_product;
    let lastItem = addon_category_product.length-1;
    if(addon_category_product[lastItem].addonCategory == ''){
        return showNoty('Fill all the details of the las item first', 'error');
    }
    if(addon_category_product[lastItem].addons.length === 0){
        return showNoty('Fill all the details of the las item first', 'error');
    }
    let item = {
        addonCategory : '',
        addons:[],
        quantity : 1,
        required : false,
        categoryAddons:[]
    };
    data.product.addon_category_product.push(item);
});
const addMoreBranches = (() => {
    let b_product = data.product.branch_product;
    let lastItem = b_product.length-1;
    if(b_product[lastItem].branches.length === 0){
        return showNoty('Fill all the details of the las item first', 'error');
    }
    let item = {
        branches : [],
        price: 0
    };
    data.product.branch_product.push(item);
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
                                    Multiple="Multiple"
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
            <div class="p-5 mt-5 intro-y box" >
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Product For Specific Branches
                    </div>
                    <div class="mt-5" v-for="(b_product,b_index) in data.product.branch_product">
                        <FormInline
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
                                    v-model="b_product.branches" :value="b_product.branches"
                                    :options="{
                                        placeholder: 'Select Branches',
                                      }"
                                    class="w-full"
                                    Multiple="Multiple"
                                >
                                    <option
                                        v-for="(branch,index) in data.branches"
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
                                        <div class="font-medium">Price</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="price"
                                    type="number"
                                    placeholder="Price"
                                    v-model="b_product.price"
                                    :value="b_product.price"
                                />
                            </div>
                        </FormInline>

                        <div class="pt-2 mt-2 xl:ml-64 xl:pl-10 first:mt-0 first:pt-0">
                            <Button
                                variant="outline-secondary"
                                class="w-full py-3 border-dashed"
                                @click="addMoreBranches()"
                            >
                                <Lucide icon="Plus" class="w-4 h-4 mr-2" /> Add More Products
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Product Addons
                    </div>
                    <div class="mt-5" v-for="(product,d_index) in data.product.addon_category_product">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Addon Category</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSelect
                                    v-model="product.addonCategory" :value="product.addonCategory"
                                    class="w-full"
                                    @change="getCategoryAddons(d_index)"
                                >
                                    <option
                                        v-for="(category,c_index) in data.addonCategories"
                                        :key="c_index"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
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
                                        <div class="font-medium">Addons</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="product.addons" :value="product.addons"
                                    :options="{
                                        placeholder: 'Select Addons',
                                      }"
                                    class="w-full"
                                    Multiple="Multiple"
                                >
                                    <option
                                        v-for="(addon,a_index) in product.categoryAddons"
                                        :key="a_index"
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
                                        <div class="font-medium">Quantity</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    min="1"
                                    id="quantity"
                                    type="number"
                                    placeholder="Quantity"
                                    v-model="product.quantity"
                                    :value="product.quantity"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Required</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        If the addon is required, then it must be bought with the product
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSwitch>
                                    <FormSwitch.Input
                                        id="addon-required"
                                        type="checkbox"
                                        v-model="product.required"
                                        :checked="product.required"
                                    />
                                    <FormSwitch.Label htmlFor="category-status-active">
                                        {{product.required ? 'Yes' : "No" }}
                                    </FormSwitch.Label>
                                </FormSwitch>
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
                                    Deal="Deal"
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
