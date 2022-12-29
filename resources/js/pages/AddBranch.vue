<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormSelect,
    FormLabel,
} from "../base-components/Form";
import Lucide from "../base-components/Lucide";

</script>
<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            branch: {
                name: '',
                area_id: 1,
                address: '',
                landmark: '',
                phone_number: ''
            },
            areas: {},
        }
    },
    mounted() {
        this.getAreas();
    },
    methods: {

        getAreas() {
            axios.get('/api/areas?get=all').then((response) => {
                this.areas = response.data.areas;
            }).catch((error) => {
                console.log(error);
            });
        },
        saveBranch(addNew = false) {
            axios.post('/api/save-branch', this.branch).then((response) => {
                if(!addNew)
                    return this.$router.push('/branches');
            }).catch((error) => {
                console.log(error);
            })
        }
    }
}
</script>
<template>
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">Add Branch</h2>
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
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Area</div>
                                        <div
                                            class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md"
                                        >
                                            Required
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSelect id="city" v-model="branch.area_id">
                                    <option
                                        v-for="(area, index) in areas"
                                        :key="index"
                                        :value="area.id"
                                    >
                                        {{ area.area }}
                                    </option>
                                </FormSelect>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'branch' }">
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
                    @click="saveBranch()"
                >
                    Save & Add New Area
                </Button>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveBranch()">
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
