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
import Litepicker from "../base-components/Litepicker";
const date = ref("");
const datepickerModalPreview = ref(false);
const setDatepickerModalPreview = (value: boolean) => {
    datepickerModalPreview.value = value;
};
const cancelButtonRef = ref(null);
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'
import {isset} from "../utils/helper";
const router = useRouter()
const route = useRoute()
onMounted(() =>{

    if (route.params.id !== undefined) {
        nextTick().then(() => {
            getDealDetails(route.params.id);
        });
    }
    getAddons();
    getCategories();
    getCities();
    getBranches();
})
let data = reactive({
    deal: {
        name: '',
        description: '',
        start_date: '',
        end_date: '',
        start_time: '',
        end_time: '',
        specific_day: '',
        specific_date: '',
        branch_id: '',
        city_id: '',
        dealProducts:[
            {
                category_id: '',
                product_id: '',
                quantity: 1,
            }
        ],
        price: 100.00,
        image: null,
        status: true
    },
    toastText : '',
    toastType : '',
    addons : [],
    categories : [],
    cities : [],
    branches : [],
});
const addDealItem = (() => {
    let lastItem = data.deal.dealProducts.length-1;
    if(data.deal.dealProducts[lastItem].category_id === '' || data.deal.dealProducts[lastItem].quantity < 1){
       return showNoty('Fill all the details of the las item first', 'error');
    }
    let item = {
        category_id: '',
        product_id: '',
        quantity: 1,
    };
    data.deal.dealProducts.push(item);
});
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
        }

    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const getDealDetails = ((id) => {
    axios.get('/api/get-deal-details/' + id).then((response) => {
        if (response.data.deal !== undefined){
            data.deal = response.data.deal;
            data.deal.city_id = data.deal.city_id ? data.deal.city_id.toString() : '';
            data.deal.branch_id = data.deal.branch_id ? data.deal.branch_id.toString() : '';
        }
    }).catch((error) => {
        showNoty(error.response.data.message,'error')
    });
});
const saveDeal = (() => {
    axios.post('/api/save-deal', data.deal).then((response) => {
        showNoty(response.data.message)
        return router.push('/admin/deals');
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
    formData.append('path',"images/deals");
    axios.post("/api/upload-image", formData, config).then((response) => {
        if (response.data.status == 'success') {
            data.deal.image = response.data.filename;
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
        <h2 class="mr-auto text-lg font-medium">Add Deal</h2>
    </div>
    <div class="grid grid-cols-11 pb-20 mt-5 gap-x-6">
        <!-- BEGIN: Notification -->
        <!-- BEGIN: Notification -->
        <div class="col-span-11 intro-y 2xl:col-span-9">

            <!-- BEGIN: Deal Information -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Deal
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
                                    v-model="data.deal.name"
                                    :value="data.deal.name"
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
                                    v-model="data.deal.description"
                                    :value="data.deal.description"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Start Date</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="data.deal.start_date"
                                        :value="data.deal.start_date"
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
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="data.deal.end_date"
                                        :value="data.deal.end_date"
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
                                    v-model="data.deal.price"
                                    :value="data.deal.price"
                                />
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
                                    v-model="data.deal.city_id" :value="data.deal.city_id"
                                    :options="{
                                        placeholder: 'Select City',
                                      }"
                                    class="w-full"
                                >
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
                                    v-model="data.deal.branch_id" :value="data.deal.branch_id"
                                    :options="{
                                        placeholder: 'Select Branch',
                                      }"
                                    class="w-full"
                                >
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
                                        If the deal is required, then it must be bought with the deal
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSwitch>
                                    <FormSwitch.Input
                                        id="deal-status"
                                        type="checkbox"
                                        v-model="data.deal.status"
                                        :checked="data.deal.status"
                                    />
                                    <FormSwitch.Label htmlFor="category-status-active">
                                        {{data.deal.status ? 'Active' : "In Active" }}
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
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5" v-if="data.deal.image !== null">
                                    <div
                                        class="relative col-span-5 cursor-pointer md:col-span-2 h-28 image-fit zoom-in"
                                    >
                                        <img
                                            class="rounded-md"
                                            alt="Avatar"
                                            :src="'/images/deals/'+data.deal.image"
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
            <!-- END: Deal Information -->
            <!-- BEGIN: Product Variant (Details) -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2" /> Deal Products
                        (Details)
                    </div>
                    <div class="mt-5" v-for="(dealItem,index) in data.deal.dealProducts">
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
                                    v-model="dealItem.category_id" :value="dealItem.category_id"
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
                                        <div class="font-medium">Quantity</div>
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
                                    v-model="dealItem.quantity"
                                    :value="dealItem.quantity"
                                />
                            </div>
                        </FormInline>
                        <div class="pt-2 mt-2 xl:ml-64 xl:pl-10 first:mt-0 first:pt-0">
                            <Button
                                variant="outline-secondary"
                                class="w-full py-3 border-dashed"
                                @click="addDealItem()"
                            >
                                <Lucide icon="Plus" class="w-4 h-4 mr-2" /> Add New Item
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'deals' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveDeal()">
                    Save
                </Button>
            </div>
        </div>
    </div>
</template>
