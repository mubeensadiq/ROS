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
import {ref, reactive , onMounted,onUpdated, nextTick} from "vue";
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()
onMounted(() =>{
    getSettings();

})
onUpdated(() => {
});
let data = reactive({
    settings: {
        company_name : null,
        company_logo : null,
        company_logo_position : null,
        company_description:null,
        company_contact:null,
        top_bar:false,
        top_bar_text:null,
        facebook_link:null,
        twitter_link:null,
    },
    loading : true,
    toastText : '',
    toastType : '',
    
});
const positions = ref(['Left','Center']);

const getSettings = (() => {
    axios.get('/api/settings' ).then((response) => {
        if (response.data.setteings !== null){
            data.settings = response.data.settings;
        }
        data.loading = false;
    }).catch((error) => {
        showNoty(error.response.data.message,'error');
        data.loading = false;
    });
});
const saveSettings = (() => {
    axios.post('/api/save-settings', data.settings).then((response) => {
        showNoty(response.data.message)
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
    formData.append('path',"images/assets");
    axios.post("/api/upload-image", formData, config).then((response) => {
        if (response.data.status == 'success') {
            data.settings.company_logo = response.data.filename;
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
        <h2 class="mr-auto text-lg font-medium">Settings</h2>
    </div>
    <div class="grid grid-cols-11 pb-20 mt-5 gap-x-6" >
        <!-- BEGIN: Notification -->
        <!-- BEGIN: Notification -->
        <div class="col-span-11 intro-y 2xl:col-span-9" v-if="!data.loading">

            <!-- BEGIN: Product Information -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        General Settings
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Company Name</div>
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
                                    v-model="data.settings.company_name"
                                    :value="data.settings.company_name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Company Description</div>
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
                                    v-model="data.settings.company_description"
                                    :value="data.settings.company_description"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Company Contact</div>
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
                                    v-model="data.settings.company_contact
                                    "
                                    :value="data.settings.company_contact
                                    "
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Top Bar</div>
                                    </div>
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        If the Top bar is Active , it will shown on top of the page
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSwitch>
                                    <FormSwitch.Input
                                        id="top-bar"
                                        name="top_bar"
                                        type="checkbox"
                                        v-model="data.settings.top_bar"
                                        :checked="data.settings.top_bar"
                                        :value="data.settings.top_bar"
                                    />
                                    <FormSwitch.Label htmlFor="top-bar">
                                        {{data.settings.top_bar ? 'Active' : "In Active" }}
                                    </FormSwitch.Label>
                                </FormSwitch>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Top Bar Text</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="top-bar-text"
                                    type="text"
                                    placeholder="Top Bar Text"
                                    v-model="data.settings.top_bar_text"
                                    :value="data.settings.top_bar_text"
                                />
                            </div>
                        </FormInline>
                        <FormInline class="flex-col items-start mt-10 xl:flex-row">
                            <FormLabel class="w-full xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Company Logo</div>
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
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5" v-if="data.settings.company_logo !== null">
                                    <div
                                        class="relative col-span-5 cursor-pointer md:col-span-2 h-28 image-fit zoom-in"
                                    >
                                        <img
                                            class="rounded-md"
                                            alt="Avatar"
                                            :src="'/images/assets/'+data.settings.company_logo"
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
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Logo Position</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.settings.company_logo_position" :value="data.settings.company_logo_position"
                                    :options="{
                                        placeholder: 'Select City',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(position , index) in positions"
                                        :value="position"
                                    >
                                        {{ position }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                    </div>
                </div>
            </div>
            <!-- END: Settings -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveSettings()">
                    Save
                </Button>
            </div>
        </div>
    </div>
</template>
