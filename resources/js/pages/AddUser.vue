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
import Tippy from "../base-components/Tippy";

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
                role: '',
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
            city_id : 1,
            update:false

        }
    },
    mounted() {
        this.getRoles();
        this.getCitiesHasAreas();
        this.getAreasByCity(false);
        if (this.$route.params.id !== undefined) {
            this.update = true;
            this.$nextTick().then(() => {
                this.getUserDetails(this.$route.params.id);
            });
        }
        else{

        }
    },
    watch: {},
    methods: {
        getRoles() {
            axios.get('/api/roles').then((response) => {
                this.roles = response.data.roles;
            }).catch((error) => {
                console.log(error);
            });
        },
        getCitiesHasAreas() {
            axios.get('/api/cities-has-areas').then((response) => {
                this.cities = response.data.cities;
            }).catch((error) => {
                console.log(error);
            });
        },
        getAreasByCity(emptyAreas = true) {
            if(emptyAreas)
                this.user.rider.areas = [];
            axios.get('/api/areas-by-city', {params: {'city_id': this.city_id}}).then((response) => {
                this.areas = response.data.areas;
                isset(this.areas[0]) ? this.user.rider.areas.push(this.areas[0].id) : '';
            }).catch((error) => {
                console.log(error);
            });
        },
        getUserDetails(id){
            axios.get('/api/get-user-details/' + id).then((response) => {
                if (response.data.user !== undefined){
                    const res = response.data.user;
                    this.user = response.data.user;
                    console.log(res);
                    this.city_id = res.rider.areas[0].area.city_id.toString();

                    if(res.roles)
                       this.$set( this.user,'role' , res.roles[0].name);
                    else
                        this.user.role = 'Rider';

                    if(response.data.user.rider !== null){
                        this.user.rider.areas.forEach((value , index) => {
                            this.user.rider.areas[index] = value.area_id.toString();
                        });

                    }
                }

            }).catch((error) => {
                console.log(error);
            });
        },
        saveUser(addNew = false) {
            axios.post('/api/save-user', this.user).then((response) => {

            }).catch((error) => {
                console.log(error);
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
                } else {
                    this.notify('error', 'Error', 'Some thing went wrong');
                }
            }).catch( (error) => {
                this.notify('error', 'Error', 'Some thing went wrong');
            });
        },
    }
}
</script>
<template>
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
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                        <Lucide icon="ChevronDown" class="w-4 h-4 mr-2"/>
                        Upload Product
                    </div>
                    <div class="mt-5">
                        <div class="flex items-center text-slate-500">
                  <span>
                    <Lucide icon="Lightbulb" class="w-5 h-5 text-warning"/>
                  </span>
                            <div class="ml-2">
                    <span class="mr-1">
                      Avoid selling counterfeit products / violating Intellectual
                      Property Rights, so that your products are not deleted.
                    </span>
                                <a
                                    href="https://themeforest.net/item/midone-jquery-tailwindcss-html-admin-template/26366820"
                                    class="font-medium text-primary"
                                    target="blank"
                                >
                                    Learn More
                                </a>
                            </div>
                        </div>
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
                                            :src="user.profile.avatar !== null ? '/images/avatar/'+user.profile.avatar : '/images/avatar/profile-2.jpg'"
                                        />
                                        <Tippy
                                            content="Remove this image?"
                                            class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 -mt-2 -mr-2 text-white rounded-full bg-danger"
                                        >
                                            <Lucide icon="X" class="w-4 h-4"/>
                                        </Tippy>
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
                                <FormSelect id="category" v-model="user.role" :value="user.role">
                                    <option
                                        v-for="(role, index) in roles"
                                        :key="index"
                                        :value="role.name"
                                    >
                                        {{ role.name }}
                                    </option>
                                </FormSelect>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <!-- BEGIN: Product Detail -->
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
                                <FormSelect id="category" @change="getAreasByCity" v-model="city_id" :value="city_id">
                                    <option
                                        v-for="(city, index) in cities"
                                        :key="index"
                                        :value="city.id"
                                    >
                                        {{ city.city }}
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
                <Button
                    type="button"
                    class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    @click="saveUser(true)"
                >
                    Save & Add New Product
                </Button>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveUser()">
                    Save
                </Button>
            </div>
        </div>
        <div class="hidden col-span-2 intro-y 2xl:block">
            <div class="sticky top-0 pt-10">
                <ul
                    class="text-slate-500 relative before:content-[''] before:w-[2px] before:bg-slate-200 before:dark:bg-darkmode-600 before:h-full before:absolute before:left-0 before:z-[-1]"
                >
                    <li
                        class="pl-5 mb-4 font-medium border-l-2 border-primary dark:border-primary text-primary"
                    >
                        <a href="">Upload Product</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Product Information</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Product Detail</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Product Variant</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Product Variant (Details)</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Product Management</a>
                    </li>
                    <li
                        class="pl-5 mb-4 border-l-2 border-transparent dark:border-transparent"
                    >
                        <a href="">Weight & Shipping</a>
                    </li>
                </ul>
                <div
                    class="relative p-5 mt-10 border rounded-md bg-warning/20 dark:bg-darkmode-600 border-warning dark:border-0"
                >
                    <Lucide
                        icon="Lightbulb"
                        class="absolute top-0 right-0 w-12 h-12 mt-5 mr-3 text-warning/80"
                    />
                    <h2 class="text-lg font-medium">Tips</h2>
                    <div class="mt-5 font-medium">Price</div>
                    <div
                        class="mt-2 text-xs leading-relaxed text-slate-600 dark:text-slate-500"
                    >
                        <div>
                            The image format is .jpg .jpeg .png and a minimum size of 300 x
                            300 pixels (For optimal images use a minimum size of 700 x 700
                            pixels).
                        </div>
                        <div class="mt-2">
                            Select product photos or drag and drop up to 5 photos at once
                            here. Include min. 3 attractive photos to make the product more
                            attractive to buyers.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
