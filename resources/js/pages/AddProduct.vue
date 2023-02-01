<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSwitch,
    FormLabel,
} from "../base-components/Form";
import TomSelect from "../base-components/TomSelect";
import Lucide from "../base-components/Lucide";
import Notification from "./Notification.vue";
import {ref, reactive , onMounted, nextTick} from "vue";
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'
import {isset} from "../utils/helper";
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
})
let data = reactive({
    product: {
        name: '',
        description: '',
        category_id: '',
        price: 10.00,
        stock: 1,
        image: null,
        min_quantity: 1,
        max_quantity: null,
        status: true,
        prep_time: '45 minutes',
        addons: []
    },
    toastText : '',
    toastType : '',
    addons : [],
    categories : []
});
const getAddons = (() => {
    axios.get('/api/addons?get=all' ).then((response) => {
        if (response.data.addons !== undefined){
            data.addons = response.data.addons;
            (isset(data.addons[0]) && data.product.addons.length === 0) ? data.product.addons.push(data.addons[0].id) : '';
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
            data.product.category_id = response.data.product.category_id.toString();
            if(response.data.product.addons !== null){
                data.product.addons.forEach((value , index) => {
                    data.product.addons[index] = value.id.toString();
                });
            }
        }
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
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
                        Product
                        Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Category</div>
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
                                    v-model="data.product.category_id" :value="data.product.category_id"
                                    :options="{
                                        placeholder: 'Select Category',
                                      }"
                                    class="w-full"
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
                                        <div class="font-medium">Stock</div>
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
                                    id="stock"
                                    type="text"
                                    placeholder="Stock"
                                    v-model="data.product.stock"
                                    :value="data.product.stock"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Minimum Quantity</div>
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
                                    id="min_quantity"
                                    type="text"
                                    placeholder="Minimum Quantity"
                                    v-model="data.product.min_quantity"
                                    :value="data.product.min_quantity"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Max Quantity</div>
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
                                    id="max_quantity"
                                    type="text"
                                    placeholder="Max Quantity"
                                    v-model="data.product.max_quantity"
                                    :value="data.product.max_quantity"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Preparation Time</div>
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
                                    id="prep_time"
                                    type="text"
                                    placeholder="Preparation Time"
                                    v-model="data.product.prep_time"
                                    :value="data.product.prep_time"
                                />
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
