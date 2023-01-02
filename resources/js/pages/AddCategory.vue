<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormInline,
    FormLabel,
    FormSwitch,
} from "../base-components/Form";

</script>
<script lang="ts">
import axios from 'axios';

export default {
    data() {
        return {
            category: {
                name: '',
                description: '',
                status: true,
                image: '',
            },
        }
    },
    mounted() {
        if (this.$route.params.id !== undefined) {
            this.$nextTick().then(() => {
                this.getCategoryDetails(this.$route.params.id);
            });
        }
    },
    methods: {
        getCategoryDetails(id) {
            axios.get('/api/get-category-details/' + id).then((response) => {
                if (response.data.category !== undefined){
                    this.category = response.data.category;
                }

            }).catch((error) => {
                console.log(error);
            });
        },
        saveCategory(addNew = false) {
            axios.post('/api/save-category', this.category).then((response) => {
                if(!addNew)
                    return this.$router.push('/categories');
            }).catch((error) => {
                console.log(error);
            })
        }
    }
}
</script>
<template>
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">Add category</h2>
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
                        Category
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
                                    v-model="category.name"
                                    :value="category.name"
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
                                    v-model="category.description"
                                    :value="category.description"
                                />
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
                                        If the status is active, then it will be displayed in menu.
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormSwitch>
                                    <FormSwitch.Input
                                        id="category-status-active"
                                        type="checkbox"
                                        v-model="category.status"
                                        :value="category.status === 1"
                                    />
                                    <FormSwitch.Label htmlFor="category-status-active">
                                        Active
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
                                    <div class="mt-3 text-xs leading-relaxed text-slate-500">
                                        <div>
                                            The image format is .jpg .jpeg .png and a minimum size of
                                            300 x 300 pixels (For optimal images use a minimum size of
                                            700 x 700 pixels).
                                        </div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div
                                class="flex-1 w-full pt-4 mt-3 border-2 border-dashed rounded-md xl:mt-0 dark:border-darkmode-400"
                            >
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
                                    />
                                </div>
                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
            <!-- END: Product Information -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <RouterLink :to="{name : 'categories' }">
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
                    @click="saveCategory()"
                >
                    Save & Add New Area
                </Button>
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="saveCategory()">
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
