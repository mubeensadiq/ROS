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
const deleteConfirmationModal = ref(false);
const setDeleteConfirmationModal = (value: boolean) => {
    deleteConfirmationModal.value = value;
};
const deleteButtonRef = ref(null);
const limits = pageLimits();
</script>
<script lang="ts">
import axios from 'axios';
export default {
    data(){
        return {
            deals: []
        }
    },
    mounted() {
        this.getDeals();
    },
    methods : {
        getDeals(url = '/api/deals'){
            axios.get(url).then((response)=>{
                this.deals = response.data.deals;
                console.log(this.deals);
            }).catch( (error) => {
                console.log(error);
            });
        }

    }
}
</script>

<template>
    <h2 class="mt-10 text-lg font-medium intro-y">Deals</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div
            class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
        >
            <RouterLink :to="{name : 'createDeal' }">
                <Button variant="primary" class="mr-2 shadow-md">
                    Add New Deal
                </Button>
            </RouterLink>

            <div class="hidden mx-auto md:block text-slate-500">
                Showing {{deals.from}} to {{ deals.to }} of {{ deals.total }} entries
            </div>
            <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <FormInput
                        type="text"
                        class="w-56 pr-10 !box"
                        placeholder="Search..."
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
                            NAME
                        </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Price </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Discounted Price </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Expiry Date </Table.Th>
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
                        v-for="(deal, index) in  deals.data"
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
                                        alt="deal Profile Image"
                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                        :src="deal.image !== null ? '/images/deals/'+deal.image : '/images/deals/profile-2.jpg'"
                                    />
                                </div>
                            </div>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ deal.name }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{deal.price}}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{deal.discounted_price}}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{deal.expiry_date}}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-40 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <div
                                :class="[
                  'flex items-center justify-center',
                  { 'text-success': deal.status === 1 },
                  { 'text-danger': deal.status === 0 },
                ]"
                            >
                                <Lucide icon="CheckSquare" class="w-4 h-4 mr-2" />
                                {{ deal.status === 1 ? "Active" : "Inactive" }}
                            </div>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
                        >
                            <div class="flex items-center justify-center">
                                <a class="flex items-center mr-3" href="">
                                    <Lucide icon="CheckSquare" class="w-4 h-4 mr-1" />
                                    Edit
                                </a>
                                <a
                                    class="flex items-center text-danger"
                                    href="#"
                                    @click="
                    (event) => {
                      event.preventDefault();
                      setDeleteConfirmationModal(true);
                    }
                  "
                                >
                                    <Lucide icon="Trash2" class="w-4 h-4 mr-1" /> Delete
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
                <Pagination.Link @click="getDeals(deals.first_page_url)">
                    <Lucide icon="ChevronsLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="deals.prev_page_url" @click="getDeals(deals.prev_page_url)">
                    <Lucide icon="ChevronLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="deals.current_page - 1 > 1">...</Pagination.Link>
                <Pagination.Link  v-if="deals.prev_page_url" @click="getDeals(deals.prev_page_url)">{{deals.current_page - 1}}</Pagination.Link>
                <Pagination.Link active>{{deals.current_page}}</Pagination.Link>
                <Pagination.Link  v-if="deals.next_page_url" @click="getDeals(deals.next_page_url)">{{deals.current_page + 1}}</Pagination.Link>
                <Pagination.Link v-if="deals.last_page - deals.current_page > 1">...</Pagination.Link>
                <Pagination.Link v-if="deals.next_page_url" @click="getDeals(deals.next_page_url)">
                    <Lucide icon="ChevronRight" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link @click="getDeals(deals.last_page_url)">
                    <Lucide icon="ChevronsRight" class="w-4 h-4" />
                </Pagination.Link>
            </Pagination>
            <label>Page Size</label>
            <select class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 w-20 mt-3 !box sm:mt-0" v-model="deals.per_page">
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
                <Button
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
