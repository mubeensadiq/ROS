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
            city: {
                city: '',
                tax_type : 'Non-GST',
                tax_amount : 0
            },
            update:false,
            toastText : '',
            toastType : 'success',
            taxTypes : ['Non-GST' , 'Inclusive Tax' , 'Exclusive Tax']
        }
    },
    mounted() {
        if (this.$route.params.id !== undefined) {
            this.update = true;
            this.$nextTick().then(() => {
                this.getCityDetails(this.$route.params.id);
            });
        }
    },
    methods: {
        getCityDetails(id) {
            axios.get('/api/get-city-details/' + id).then((response) => {
                if (response.data.city !== undefined){
                    this.city = response.data.city;
                }

            }).catch((error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        saveCity() {
            axios.post('/api/save-city', this.city).then((response) => {
                this.showNoty(response.data.message)
                return this.$router.push('/admin/cities');
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
        <h2 class="mr-auto text-lg font-medium">{{update ? 'Update City' : 'Add New City'}}</h2>
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
                        City
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
                                    placeholder="City name"
                                    v-model="city.city"
                                    :value="city.city"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Tax Type</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="city.tax_type" :value="city.tax_type"
                                    :options="{
                                        placeholder: 'Select Tax Type',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(type, index) in taxTypes"
                                        :key="index"
                                        :value="type"
                                    >
                                        {{ type }}
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
                                        <div class="font-medium"> Tax Amount (In Percent)</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="tax_amount"
                                    type="text"
                                    placeholder="Tax Amount"
                                    v-model="city.tax_amount"
                                    :value="city.tax_amount"
                                />
                            </div>
                        </FormInline>


                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'cities' }">
                    <Button
                        type="button"
                        class="w-full py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 md:w-52"
                    >
                        Cancel
                    </Button>
                </RouterLink>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveCity()">
                    {{ update ? 'Update' : 'Save' }}
                </Button>
            </div>
        </div>
    </div>
</template>
