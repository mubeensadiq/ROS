<script setup lang="ts">
import _ from "lodash";
import { ref } from "vue";
import Button from "../base-components/Button";
import {pageLimits} from "../utils/helper";
import Pagination from "../base-components/Pagination";
import { FormInput, FormSelect } from "../base-components/Form";
import Lucide from "../base-components/Lucide";
import Tippy from "../base-components/Tippy";
import { Dialog, Menu } from "../base-components/Headless";
import Table from "../base-components/Table";
const deleteButtonRef = ref(null);
const limits = pageLimits();
import Notification from "./Notification.vue";
</script>
<script lang="ts">
import axios from 'axios';
export default {
    data(){
        return {
            categories: [],
            categoryID: 0,
            deleteConfirmationModal: false,
            toastText : '',
            toastType : 'success',
            search:''
        }
    },
    mounted() {
        this.getCategories();
    },
    methods : {
        getCategories(url = '/api/categories'){
            axios.get(url).then((response)=>{
                this.categories = response.data.categories;
            }).catch( (error) => {
                this.showNoty(error.response.data.message, 'error')
            });
        },
        setDeleteConfirmationModal(value, id = 0) {
            this.categoryID = id;
            this.deleteConfirmationModal = value;
        },
        deleteCategory() {
            axios.delete('/api/delete-category/' + this.categoryID).then((response) => {
                if (response.data.status === 'success') {
                    this.showNoty(response.data.message)
                    this.getCategories("/api/categories?page=" + this.categories.current_page);
                    this.deleteConfirmationModal = false;
                }
            }).catch((error) => {
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
    <h2 class="mt-10 text-lg font-medium intro-y">Categories</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div
            class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
        >
            <RouterLink v-if="$can('categories.create')" :to="{name : 'categories.create' }">
                <Button variant="primary" class="mr-2 shadow-md">
                    Add New Category
                </Button>
            </RouterLink>

            <div class="hidden mx-auto md:block text-slate-500">
                Showing {{categories.from}} to {{ categories.to }} of {{ categories.total }} entries
            </div>
            <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <FormInput
                        type="text"
                        class="w-56 pr-10 !box"
                        placeholder="Search..."
                        v-model="search"
                        @keypress.enter="getCategories('/api/categories?search='+search)"
                    />
                    <Lucide
                        icon="Search"
                        class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3"
                    />
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <Table class="border-spacing-y-[10px] border-separate -mt-2">
                <Table.Thead>
                    <Table.Tr>
                        <Table.Th class="border-b-0 whitespace-nowrap"> IMAGE </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap">
                            NAME
                        </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap">
                            DESCRIPTION
                        </Table.Th>
                        <Table.Th class="text-center border-b-0 whitespace-nowrap">
                            STATUS
                        </Table.Th>
                        <Table.Th class="text-center border-b-0 whitespace-nowrap">
                            ACTIONS
                        </Table.Th>
                    </Table.Tr>
                </Table.Thead>
                <Table.Tbody>
                    <Table.Tr
                        v-for="(category, index) in  categories.data"
                        :key="index"
                        class="intro-x"
                    >
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-40 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <Tippy
                                        as="img"
                                        alt="User Profile Image"
                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                        :src="category.image !== null ? '/images/categories/'+category.image : '/images/categories/profile-2.jpg'"
                                    />
                                </div>
                            </div>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ category.name }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ category.description }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-40 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <div
                                :class="[
                  'flex items-center justify-center',
                  { 'text-success': category.status === 1 },
                  { 'text-danger': category.status === 0 },
                ]"
                            >
                                <Lucide icon="CheckSquare" class="w-4 h-4 mr-2" />
                                {{ category.status === 1 ? "Active" : "Inactive" }}
                            </div>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
                        >
                            <div class="flex items-center justify-center">
                                <RouterLink v-if="$can('categories.update')" :to="{name : 'categories.update', params:{'id' : category.id} }"
                                            class="flex items-center mr-3">
                                    <Lucide icon="CheckSquare" class="w-4 h-4 mr-1"/>
                                    Edit
                                </RouterLink>
                                <a v-if="$can('categories.remove')"
                                   class="flex items-center text-danger"
                                    href="#"
                                    @click="
                                        (event) => {
                                            event.preventDefault();
                                            setDeleteConfirmationModal(true , category.id);
                                        }
                                    "
                                >
                                    <Lucide icon="Trash2" class="w-4 h-4 mr-1"/>
                                    Delete
                                </a>
                            </div>
                        </Table.Td>
                    </Table.Tr>
                </Table.Tbody>
            </Table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div
            class="flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"
        >
            <Pagination class="w-full sm:w-auto sm:mr-auto">
                <Pagination.Link @click="getCategories(categories.first_page_url)">
                    <Lucide icon="ChevronsLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="categories.prev_page_url" @click="getCategories(categories.prev_page_url)">
                    <Lucide icon="ChevronLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="categories.current_page - 1 > 1">...</Pagination.Link>
                <Pagination.Link  v-if="categories.prev_page_url" @click="getCategories(categories.prev_page_url)">{{categories.current_page - 1}}</Pagination.Link>
                <Pagination.Link active>{{categories.current_page}}</Pagination.Link>
                <Pagination.Link  v-if="categories.next_page_url" @click="getCategories(categories.next_page_url)">{{categories.current_page + 1}}</Pagination.Link>
                <Pagination.Link v-if="categories.last_page - categories.current_page > 1">...</Pagination.Link>
                <Pagination.Link v-if="categories.next_page_url" @click="getCategories(categories.next_page_url)">
                    <Lucide icon="ChevronRight" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link @click="getCategories(categories.last_page_url)">
                    <Lucide icon="ChevronsRight" class="w-4 h-4" />
                </Pagination.Link>
            </Pagination>
            <label>Page Size</label>
            <select class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 w-20 mt-3 !box sm:mt-0" v-model="categories.per_page">
                <option v-for="page in limits" :value="page">{{page}}</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <Dialog
        :open="deleteConfirmationModal"
        @close="
      () => {
        setDeleteConfirmationModal(false);
      }
    "
        :initialFocus="deleteButtonRef"
    >
        <Dialog.Panel>
            <div class="p-5 text-center">
                <Lucide icon="XCircle" class="w-16 h-16 mx-auto mt-3 text-danger" />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete these records? <br />
                    This process cannot be undone.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <Button
                    variant="outline-secondary"
                    type="button"
                    @click="
            () => {
              setDeleteConfirmationModal(false);
            }
          "
                    class="w-24 mr-1"
                >
                    Cancel
                </Button>
                <Button  @click="deleteCategory()"
                    variant="danger"
                    type="button"
                    class="w-24"
                    ref="deleteButtonRef"
                >
                    Delete
                </Button>
            </div>
        </Dialog.Panel>
    </Dialog>
    <!-- END: Delete Confirmation Modal -->
</template>
