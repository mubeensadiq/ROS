<script setup lang="ts">
import _ from "lodash";
import { ref, reactive , onMounted } from "vue";
import Button from "../base-components/Button";
import {pageLimits} from "../utils/helper";
import Pagination from "../base-components/Pagination";
import { FormInline , FormInput, FormSelect, FormLabel} from "../base-components/Form";
import Lucide from "../base-components/Lucide";
import Tippy from "../base-components/Tippy";
import { Dialog, Menu } from "../base-components/Headless";
import Table from "../base-components/Table";
import TomSelect from "../base-components/TomSelect";
const statusButtonRef = ref(null);
const limits = pageLimits();
import Notification from "./Notification.vue";
import axios from "axios";
const data = reactive({ orders: [], riders:{}, order:{}, orderStatusModal: false, toastText : '', toastType : 'success', search:'' })
const orderStatus = ref(['ALL','Received' , 'Preparing', 'Completed','Cancelled']);
onMounted(() => {
    getOrders();
    getRiders();
})

const getOrders = ((url = '/api/orders') => {
    axios.get(url).then((response)=>{
        data.orders = response.data.orders;
    }).catch( (error) => {
        showNoty(error.response.data.message, 'error')
    });
});
const getRiders = ((url = '/api/riders?get=all') => {
    axios.get(url).then((response)=>{
        data.riders = response.data.riders;
    }).catch( (error) => {
        showNoty(error.response.data.message, 'error')
    });
});
const setOrderStatusModal = ((value, order = {}) =>{
    data.order = order;
    data.orderStatusModal = value;
});
const updateOrder = (()=> {
    axios.post('/api/update-order',  data.order).then((response) => {
        if (response.data.status === 'success') {
            showNoty(response.data.message)
            getOrders("/api/orders?page=" + data.orders.current_page);
            data.orderStatusModal = false;
        }
    }).catch((error) => {
        showNoty(error.response.data.message, 'error')
    });
});
const showNoty = ((message,type = 'success') => {
    data.toastText = message;
    data.toastType = type;
    document.getElementById("toastBtn").click();
});

</script>

<template>
    <Notification :toastText="data.toastText" :toastType="data.toastType" />
    <h2 class="mt-10 text-lg font-medium intro-y">Orders</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div
            class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
        >
            <RouterLink v-if="$can('orders.create')" :to="{name : 'orders.create' }">
                <Button variant="primary" class="mr-2 shadow-md">
                    Add New Order
                </Button>
            </RouterLink>

            <div class="hidden mx-auto md:block text-slate-500">
                Showing {{data.orders.from}} to {{ data.orders.to }} of {{ data.orders.total }} entries
            </div>
            <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <FormInput
                        type="text"
                        class="w-56 pr-10 !box"
                        placeholder="Search..."
                        v-model="data.search"
                        @keypress.enter="getOrders('/api/orders?search='+data.search)"
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
                        <Table.Th class="border-b-0 whitespace-nowrap"> Order Number </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Customer Name </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Customer Phone </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Rider </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Total </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Status </Table.Th>
                        <Table.Th class="text-center border-b-0 whitespace-nowrap">
                            ACTIONS
                        </Table.Th>
                    </Table.Tr>
                </Table.Thead>
                <Table.Tbody>
                    <Table.Tr
                        v-for="(order, index) in  data.orders.data"
                        :key="index"
                        class="intro-x"
                    >
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ order.order_number }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ order.customer_name }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ order.phone_number }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{order.rider !== null ? order.rider.name : '-'}}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ order.total }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ order.status }}
                            </span>
                        </Table.Td>


                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
                        >
                            <div class="flex items-center justify-center">
                                <RouterLink v-if="$can('order.details')" :to="{name : 'order.details', params:{'id' : order.id} }"
                                            class="flex items-center mr-3">
                                    <Lucide icon="CheckSquare" class="w-4 h-4 mr-1"/>
                                    Details
                                </RouterLink>
                                <a 
                                    class="flex items-center text-warning"
                                    href="#"
                                    @click="
                                        (event) => {
                                            event.preventDefault();
                                            setOrderStatusModal(true , order);
                                        }
                                    "
                                >
                                <Lucide icon="CheckSquare" class="w-4 h-4 mr-1"/>
                                    Update
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
                <Pagination.Link @click="getOrders(data.orders.first_page_url)">
                    <Lucide icon="ChevronsLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="data.orders.prev_page_url" @click="getOrders(data.orders.prev_page_url)">
                    <Lucide icon="ChevronLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="data.orders.current_page - 1 > 1">...</Pagination.Link>
                <Pagination.Link  v-if="data.orders.prev_page_url" @click="getOrders(data.orders.prev_page_url)">{{data.orders.current_page - 1}}</Pagination.Link>
                <Pagination.Link active>{{data.orders.current_page}}</Pagination.Link>
                <Pagination.Link  v-if="data.orders.next_page_url" @click="getOrders(data.orders.next_page_url)">{{data.orders.current_page + 1}}</Pagination.Link>
                <Pagination.Link v-if="data.orders.last_page - data.orders.current_page > 1">...</Pagination.Link>
                <Pagination.Link v-if="data.orders.next_page_url" @click="getOrders(data.orders.next_page_url)">
                    <Lucide icon="ChevronRight" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link @click="getOrders(data.orders.last_page_url)">
                    <Lucide icon="ChevronsRight" class="w-4 h-4" />
                </Pagination.Link>
            </Pagination>
            <label>Page Size</label>
            <select class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 w-20 mt-3 !box sm:mt-0" v-model="data.orders.per_page">
                <option v-for="page in limits" :value="page">{{page}}</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <Dialog
        :open="data.orderStatusModal"
        @close="
      () => {
        setOrderStatusModal(false);
      }
    "
        :initialFocus="statusButtonRef"
    >
        <Dialog.Panel>
            <div class="p-5 text-center">
                <div class="mt-2 text-3xl">Update Order Status And Assign Rider</div>
                <div class="mt-2 text-slate-500">
                    <div class="p-5 mt-2 intro-y box">
                <div
                    class="p-5 border rounded-md border-slate-200/60 dark:border-darkmode-400"
                >
                    <div
                        class="flex items-center pb-5 text-base font-medium border-b border-slate-200/60 dark:border-darkmode-400"
                    >
                    </div>
                    <div class="mt-2">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Status</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.order.status" :value="data.order.status"
                                    :options="{
                                        placeholder: 'Order Status',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(status, index) in orderStatus"
                                        :key="index"
                                        :value="status"
                                    >
                                        {{ status }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Riders</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="data.order.rider" :value="data.order.rider"
                                    :options="{
                                        placeholder: 'Select Rider',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(rider, index) in data.riders"
                                        :key="index"
                                        :value="rider.id"
                                    >
                                        {{ rider.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>

                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <Button
                    variant="outline-secondary"
                    type="button"
                    @click="
            () => {
              setOrderStatusModal(false);
            }
          "
                    class="w-24 mr-1"
                >
                    Cancel
                </Button>
                <Button
                    variant="success"
                    type="button"
                    class="w-24"
                    ref="statusButtonRef"
                    @click="updateOrder"
                >
                    Update
                </Button>
            </div>
        </Dialog.Panel>
    </Dialog>
    <!-- END: Delete Confirmation Modal -->
</template>
