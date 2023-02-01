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
            branch: {
                name: '',
                areas: [],
                address: '',
                landmark: '',
                phone_number: '',
            },
            areas: {},
            update:false,
            toastText : '',
            toastType : 'success',
            city_id : 1
        }
    },
    mounted() {

        if (this.$route.params.id !== undefined) {
            this.update = true
            this.$nextTick().then(() => {
                this.getBranchDetails(this.$route.params.id);
            });
        }
        else{
            this.getAreas();
        }

    },
    methods: {

        getAreas() {
            axios.get('/api/areas-by-city', {params: {'city_id': this.city_id}}).then((response) => {
                this.areas = response.data.areas;
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        async getBranchDetails(id) {
            await axios.get('/api/get-branch-details/' + id).then((response) => {
                if (response.data.branch !== undefined){
                    this.branch = response.data.branch;
                    if(response.data.branch.areas.length > 0){
                        this.city_id = response.data.branch.areas[0].city_id;
                        this.branch.areas.forEach((value , index) => {
                            this.branch.areas[index] = value.id.toString();
                        });
                    }
                }
                this.getAreas();
            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        saveBranch() {
            axios.post('/api/save-branch', this.branch).then((response) => {
                this.showNoty(response.data.message)
                return this.$router.push('/admin/branches');
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
        <h2 class="mr-auto text-lg font-medium">{{update ? 'Update Branch' : 'Add New Branch'}}</h2>
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
                        Branch
                        Information
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Branch Name</div>
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
                                    id="branch-name"
                                    type="text"
                                    placeholder="Branch name"
                                    v-model="branch.name"
                                    :value="branch.name"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Branch Address</div>
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
                                    id="branch-address"
                                    type="text"
                                    placeholder="Branch Address"
                                    v-model="branch.address"
                                    :value="branch.address"
                                />
                            </div>
                        </FormInline>

                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Landmark</div>
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
                                    id="landmark"
                                    type="text"
                                    placeholder="Landmark"
                                    v-model="branch.landmark"
                                    :value="branch.landmark"
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
                                    v-model="branch.phone_number"
                                    :value="branch.phone_number"
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
                                    v-model="branch.areas" :value="branch.areas"
                                    :options="{
                                        placeholder: 'Select Areas',
                                      }"
                                    class="w-full"
                                    multiple="multiple"
                                >
                                    <option
                                        v-for="(area, index) in areas"
                                        :key="index"
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
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'branches' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveBranch()">
                    {{ update ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
    </div>
</template>
