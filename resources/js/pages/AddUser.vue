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
                original_password: '',
                role: '',
                profile: {
                    avatar: null,
                    phone_number: '',
                    address: ''
                },

            },
            role : localStorage.getItem('role'),
            userRole : null,
            roles: [],
            update:false,
            toastText : '',
            toastType : 'success'

        }
    },
    mounted() {
        this.getRoles();
        if (this.$route.params.id !== undefined) {
            this.update = true;
            this.$nextTick().then(() => {
                this.getUserDetails(this.$route.params.id);
            });
        }
    },
    watch: {},
    methods: {
        getRoles() {
            axios.get('/api/roles').then((response) => {
                this.roles = response.data.roles;
                if(!this.update)
                    this.user.role = this.roles[0].id.toString();
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getUserDetails(id){
            axios.get('/api/get-user-details/' + id).then((response) => {
                if (response.data.user !== undefined){
                    const res = response.data.user;
                    this.user = response.data.user;
                    this.userRole = res.roles[0];
                    this.user.role = res.roles[0].id.toString();
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
                        <FormInline v-if="role === 'Super Admin'"
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
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
                                    type="password"
                                    placeholder="Password"
                                    v-model="user.original_password"
                                    :value="user.original_password"
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
    </div>
</template>
