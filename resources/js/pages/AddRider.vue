<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSelect,
    FormLabel,
} from "../base-components/Form";
import TomSelect from "../base-components/TomSelect";
import Lucide from "../base-components/Lucide";
import Notification from "./Notification.vue";
</script>
<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            rider: {
                branch_id: '',
                name: '',
                phone_number_1: '',
                phone_number_2: '',
                nic_image: null,
            },
            branches: {},
            cities: {},
            update:false,
            toastText : '',
            toastType : 'success',
            city_id : ''
        }
    },
    watch:{
        city_id(){
            this.getBranches();
        }
    },
    mounted() {
        this.getCities();
        if (this.$route.params.id !== undefined) {
            this.update = true
            this.$nextTick().then(() => {
                this.getRiderDetails(this.$route.params.id);
            });
        }

    },
    methods: {
        getCities() {
            axios.get('/api/cities?get=all').then((response) => {
                this.cities = response.data.cities;
                if(this.city_id == '')
                    this.city_id = this.cities[0].id;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getBranches() {
            axios.get('/api/branches', {params: {'city_id': this.city_id}}).then((response) => {
                this.branches = response.data.branches;
                if(!this.rider.branch_id && this.branches.length > 0){
                    console.log("sadsads");
                    this.rider.branch_id = this.branches[0].id;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        async getRiderDetails(id) {
            await axios.get('/api/get-rider-details/' + id).then((response) => {
                if (response.data.rider !== undefined){
                    this.rider = response.data.rider;
                    if(response.data.rider.branch){
                        this.city_id = this.rider.branch.areas[0].city_id.toString();
                    }
                }
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        saveRider() {
            axios.post('/api/save-rider', this.rider).then((response) => {
                this.showNoty(response.data.message)
                return this.$router.push('/admin/riders');
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            })
        },
        showNoty(message,type = 'success'){
            this.toastText = message;
            this.toastType = type;
            document.getElementById("toastBtn").click();
        },
        uploadCNIC(event){
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            };
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('image',file);
            formData.append('path',"images/riders");
            axios.post("/api/upload-image", formData, config).then((response) => {
                if (response.data.status == 'success') {
                    this.rider.nic_image = response.data.filename;
                }
                this.showNoty(response.data.message)
            }).catch( (error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
    }
}
</script>
<template>
    <Notification :toastText="toastText" :toastType="toastType" />
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">{{update ? 'Update Rider' : 'Add New Rider'}}</h2>
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
                        Rider
                        Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Rider Name</div>
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
                                    id="rider-name"
                                    type="text"
                                    placeholder="Name"
                                    v-model="rider.name"
                                    :value="rider.name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Phone Number 1</div>
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
                                    id="phone-number"
                                    type="text"
                                    placeholder="Phone Number"
                                    v-model="rider.phone_number_1"
                                    :value="rider.phone_number_1"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Phone Number 2</div>
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
                                    id="phone-number"
                                    type="text"
                                    placeholder="Phone Number 2"
                                    v-model="rider.phone_number_2"
                                    :value="rider.phone_number_2"
                                />
                            </div>
                        </FormInline>
                        <FormInline
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
                                    v-model="city_id" :value="city_id"
                                    :options="{
                                        placeholder: 'Select City',
                                      }"
                                    class="w-full"
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
                                    v-model="rider.branch_id" :value="rider.branch_id"
                                    :options="{
                                        placeholder: 'Select Branch',
                                      }"
                                    class="w-full"
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
                        <FormInline class="flex-col items-start mt-10 xl:flex-row">
                            <FormLabel class="w-full xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">CNIC</div>
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
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5" v-if="rider.nic_image !== null">
                                    <div
                                        class="relative col-span-5 cursor-pointer md:col-span-2 h-28 image-fit zoom-in"
                                    >
                                        <img
                                            class="rounded-md"
                                            alt="Avatar"
                                            :src="'/images/riders/'+rider.nic_image"
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
                                        @change="uploadCNIC($event)"
                                    />
                                </div>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'riders' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveRider()">
                    {{ update ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
    </div>
</template>
