<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSelect,
    FormLabel,
} from "../base-components/Form";
import Lucide from "../base-components/Lucide";
import TomSelect from "../base-components/TomSelect";
import Notification from "./Notification.vue";
</script>
<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            role: {
                name: '',
                permissions: []
            },
            permissions: [],
            update:false,
            toastText : '',
            toastType : 'success'
        }
    },
    mounted() {
        this.getPermissions();
        if (this.$route.params.id !== undefined) {
            this.update = true;
            this.$nextTick().then(() => {
                this.getRoleDetails(this.$route.params.id);
            });
        }
    },
    methods: {
        getRoleDetails(id) {
            axios.get('/api/get-role-details/' + id).then((response) => {
                if (response.data.role !== undefined){
                    this.role = response.data.role;
                    this.role.permissions.forEach((value , index) => {
                        this.role.permissions[index] = value.id.toString();
                    });
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        getPermissions(){
            axios.get('/api/permissions').then((response) => {
                if (response.data.permissions !== undefined){
                    this.permissions = response.data.permissions;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        saveRole() {
            axios.post('/api/save-role', this.role).then((response) => {
                this.showNoty(response.data.message)
                return this.$router.push('/admin/roles');
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
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
        <h2 class="mr-auto text-lg font-medium">{{update ? 'Update Rle' : 'Add New Role'}}</h2>
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
                        Role
                        Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium"> Name</div>
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
                                    id="area"
                                    type="text"
                                    placeholder="Area name"
                                    v-model="role.name"
                                    :value="role.name"
                                />
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
                                    v-model="role.permissions"
                                    :value="role.permissions"
                                    :options="{
                                    placeholder: 'Permissions',
                                  }"
                                    class="w-full"
                                    multiple
                                >
                                    <option
                                        v-for="(permission, key) in permissions"
                                        :key="key"
                                        :value="permission.id"
                                    >
                                        {{ permission.name }}
                                    </option>
                                </TomSelect>
                            </div>
                        </FormInline>


                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'areas' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveRole()">
                    {{ update ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
    </div>
</template>
