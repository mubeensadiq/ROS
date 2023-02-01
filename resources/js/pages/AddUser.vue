<script setup lang="ts">
import _ from "lodash";
import fakerData from "../utils/faker";
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
import {isset} from "../utils/helper";

export default {
    data() {
        return {
            user: {
                first_name: '',
                last_name: '',
                username: '',
                email: '',
                password: '',
                role: 1,
                profile: {
                    avatar: null,
                    phone_number: '',
                    address: ''
                },
                rider: {
                    cnic: '',
                    license_no: '',
                    areas: []
                },

            },
            roles: [],
            areas: {},
            cities: {},
            city_id : '',
            update:false,
            toastText : '',
            toastType : 'success'

        }
    },
    mounted() {
        this.getCitiesHasAreas();
        this.getRoles();

        if (this.$route.params.id !== undefined) {
            this.update = true;
            this.$nextTick().then(() => {
                this.getUserDetails(this.$route.params.id);
            });
        }
        else{
            this.getAreasByCity();
        }
    },
    watch: {},
    methods: {
        getRoles() {
            axios.get('/api/roles').then((response) => {
                this.roles = response.data.roles;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getCitiesHasAreas() {
            axios.get('/api/cities-has-areas').then((response) => {
                this.cities = response.data.cities;
                if(this.$route.params.id == undefined)
                    this.city_id = this.cities[0].id.toString();
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getAreasByCity() {
            axios.get('/api/areas-by-city', {params: {'city_id': this.city_id}}).then((response) => {
                this.areas = response.data.areas;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getUserDetails(id){
            axios.get('/api/get-user-details/' + id).then((response) => {
                if (response.data.user !== undefined){
                    const res = response.data.user;
                    this.user = response.data.user;
                    this.city_id = this.cities[0].id.toString();
                    if(res.roles)
                        this.user.role = res.roles[0].id.toString();
                    this.getAreasByCity();
                    if(res.rider){
                        this.city_id = res.rider.areas[0].area.city_id.toString();
                        setTimeout(()=>{
                            if(response.data.user.rider !== null){
                                this.user.rider.areas.forEach((value , index) => {
                                    this.user.rider.areas[index] = value.area_id.toString();
                                });
                            }
                        },10)
                    }
                    else{
                        this.user.rider = {
                            cnic: '',
                            license_no: '',
                            areas: []
                        }
                    }

                }

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        saveUser(addNew = false) {
            axios.post('/api/save-user', this.user).then((response) => {
                this.showNoty(response.data.message)
                if(!addNew)
                    return this.$router.push('/admin/users');

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            })
        },
        uploadImage(event){
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            };
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('image',file);
            formData.append('path',"images/avatar");
            axios.post("/api/upload-image", formData, config).then((response) => {
                if (response.data.status == 'success') {
                    this.user.profile.avatar = response.data.filename;
                }
                this.showNoty(response.data.message)
            }).catch( (error) => {
                this.showNoty(error.response.data.message, 'error')
            });
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
        <h2 class="mr-auto text-lg font-medium">{{update ? 'Update User' : 'Add New User'}}</h2>
    </div>
    <div class="grid grid-cols-11 pb-20 mt-5 gap-x-6">
        <!-- BEGIN: Notification -->
        <!-- BEGIN: Notification -->
        <div class="col-span-11 intro-y 2xl:col-span-9">
            <div class="p-5 intro-y box" v-if="!update">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div class="mt-5">
                        <FormInline class="flex-col items-start mt-10 xl:flex-row">
                            <FormLabel class="w-full xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">User Avatar</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div
                                class="flex-1 w-full pt-4 mt-3 border-2 border-dashed rounded-md xl:mt-0 dark:border-darkmode-400"
                            >
                                <div class="grid grid-cols-10 gap-5 pl-4 pr-5">
                                    <div
                                        class="relative col-span-5 cursor-pointer md:col-span-2 h-28 image-fit zoom-in"
                                    >
                                        <img
                                            class="rounded-md"
                                            alt="Avatar"
                                            :src="user.profile.avatar !== null ? '/images/avatar/'+user.profile.avatar : '/images/avatar/default.png'"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="relative flex items-center justify-center px-4 pb-4 mt-5 cursor-pointer"
                                >
                                    <Lucide icon="Image" class="w-4 h-4 mr-2"/>
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
            <!-- END: Uplaod Product -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        User
                        Access
                    </div>
                    <div class="mt-5">

                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Role</div>
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
                                    v-model="user.role"
                                    :value="user.role"
                                    :options="{
                                    placeholder: 'Roles',
                                  }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(role, index) in roles"
                                        :key="index"
                                        :value="role.id"
                                    >
                                        {{ role.name }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- BEGIN: Product Information -->
            <div class="p-5 mt-5 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        User
                        Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">First Name</div>
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
                                    id="last-name"
                                    type="text"
                                    placeholder="First name"
                                    v-model="user.first_name"
                                    :value="user.first_name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Last Name</div>
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
                                    id="last-name"
                                    type="text"
                                    placeholder="Last name"
                                    v-model="user.last_name"
                                    :value="user.last_name"
                                />
                            </div>
                        </FormInline>

                        <FormInline v-if="!update"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">UserName</div>
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
                                    id="user-name"
                                    type="text"
                                    placeholder="User name"
                                    v-model="user.username"
                                    :value="user.username"
                                />
                            </div>
                        </FormInline>
                        <FormInline v-if="!update"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Email</div>
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
                                    id="email"
                                    type="email"
                                    placeholder="Email"
                                    v-model="user.email"
                                    :value="user.email"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0" v-if="!update"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Password</div>
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
                                    id="password"
                                    type="text"
                                    placeholder="Password"
                                    v-model="user.password"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Address</div>
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
                                    id="address"
                                    type="text"
                                    placeholder="Address"
                                    v-model="user.profile.address"
                                    :value="user.profile.address"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Phone Number</div>
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
                                    v-model="user.profile.phone_number"
                                    :value="user.profile.phone_number"
                                />
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <!-- BEGIN: Product Detail -->
            <div class="p-5 mt-5 intro-y box" v-if="user.role === '5'">
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
                                        <div class="font-medium">CNIC</div>
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
                                    id="cnic"
                                    type="text"
                                    placeholder="cnic"
                                    v-model="user.rider.cnic"
                                    :value="user.rider.cnic"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">License Number</div>
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
                                    id="cnic"
                                    type="text"
                                    placeholder="license no"
                                    v-model="user.rider.license_no"
                                    :value="user.rider.license_no"
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
                                    v-model="city_id"
                                    :value="city_id"
                                    :options="{
                                    placeholder: 'Cities',
                                  }"
                                    class="w-full"
                                    @change="getAreasByCity"
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
                                        <div class="font-medium">Areas</div>
                                    </div>
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        You can choose multiple areas for single rider.
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="user.rider.areas"
                                    :value="user.rider.areas"
                                    :options="{
                                    placeholder: 'Areas',
                                  }"
                                    class="w-full"
                                    multiple
                                >
                                    <option
                                        v-for="(area, key) in areas"
                                        :key="key"
                                        :value="area.id"
                                    >
                                        {{ area.area }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Weight & Shipping -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'users' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveUser()">
                    {{ update ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
        <div class="hidden col-span-2 intro-y 2xl:block">
            <div class="sticky top-0 pt-10">
                <ul
                    class="text-slate-500 relative before:content-[''] before:w-[2px] before:bg-slate-200 before:dark:bg-darkmode-600 before:h-full before:absolute before:left-0 before:z-[-1]"
                >
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">User Information</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Rider Information</a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</template>
