<script setup lang="ts">
import Button from "../base-components/Button";
import {
    FormInput,
    FormSelect,
    FormInline,
    FormSwitch,
    FormLabel,
} from "../base-components/Form";
import Pagination from "../base-components/Pagination";
import TomSelect from "../base-components/TomSelect";
import Table from "../base-components/Table";
import {pageLimits} from "../utils/helper";
import Litepicker from "../base-components/Litepicker";
const date = ref("");
const datepickerModalPreview = ref(false);
import Lucide from "../base-components/Lucide";
import {ref, reactive , onMounted,onUpdated, nextTick} from "vue";
import axios from "axios";
import dayjs from "dayjs";
import { useRouter, useRoute } from 'vue-router'
const salesReportFilter = ref<string>("");
onMounted(() =>{
    getProducts();
    getBranches();
})
onUpdated(() => {
    
});
const filter = reactive({
        branch : null,
        area : null,
        rider : null,
        order_status : null,
        order_type : null,
        product : null,
        category : null,
        customer : null,
        phone_number:null,
        start_date:dayjs().format("DD MMMM YYYY"),
        end_date:dayjs().format("DD MMMM YYYY"),
        start_time:'',
        end_time:''
});
const loading = ref(false);
const products = ref<object>({});
const branches = ref<object>({});
const orderTypes = ref(['ALL','Pickup','Delivery']);
const orderStatus = ref(['ALL','Received' , 'Preparing', 'Completed','Cancelled']);
const records = ref<object>({});
const getReport = (() => {
    loading.value = true;
    const format = "YYYY-MM-D";
    
    filter.start_date = dayjs(filter.start_date).format(format);
    filter.end_date = dayjs(filter.end_date).format(format);
    axios.get('/api/report/get-report' , {params: {filter : filter}} ).then((response) => {
        if (response.data.records !== null){
            records.value = response.data.records;
        }
        loading.value = false;
    }).catch((error) => {
        loading.value = false;
    });
});
const getProducts = (() => {
    axios.get('/api/products?get=all').then((response) => {
        products.value = response.data.products;
    }).catch((error) => {
        console.log(error);
    })
});
const getBranches = (() => {
    axios.get('/api/branches?get=all').then((response) => {
        branches.value = response.data.branches;
    }).catch((error) => {
        console.log(error);
    })
});
const dateFormat = ((date) => {
    return dayjs(date)
        .format("DD MMMM YYYY");
})
</script>
<template>
    <div class="flex items-center mt-8 intro-y">
        <div class="items-center block h-10 intro-y sm:flex">
            <h2 class="mr-auto text-lg font-medium">Report</h2>
        </div>
    </div>
    <div class="grid grid-cols-11 pb-20 mt-5 gap-x-6" >
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
                        APPLY FILTER
                    </div>
                    <div class="mt-5">
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Start Date</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="filter.start_date"
                                        :value="filter.start_date"
                                        placeholder="Start Date"
                                        :options="{
                                            autoApply: true,
                                            showWeekNumbers: true,
                                            dropdowns: {
                                                minYear: 2023,
                                                maxYear: null,
                                                months: true,
                                                years: true,
                                            },
                                        }"
                                    />
                                </Preview.Panel>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">End Date</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <Preview.Panel>
                                    <Litepicker
                                        v-model="filter.end_date"
                                        :value="filter.end_date"
                                        placeholder="End Date"
                                        :options="{
                                            autoApply: true,
                                            showWeekNumbers: true,
                                            dropdowns: {
                                                minYear: 1990,
                                                maxYear: null,
                                                months: true,
                                                years: true,
                                            },
                                        }"
                                    />
                                </Preview.Panel>
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Start Time</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="start_time"
                                    type="time"
                                    placeholder="start time"
                                    v-model="filter.start_time"
                                    :value="filter.start_time"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">End Time</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <FormInput
                                    id="end_time"
                                    type="time"
                                    placeholder="end time"
                                    v-model="filter.end_time"
                                    :value="filter.end_time"
                                />
                            </div>
                        </FormInline>
                        <FormInline
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Order Status</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="filter.order_status" :value="filter.order_status"
                                    :options="{
                                        placeholder: 'Select Order Status',
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
                            class="flex-col items-start pt-5 mt-5 xl:flex-row first:mt-0 first:pt-0"
                        >
                            <FormLabel class="xl:w-64 xl:!mr-10">
                                <div class="text-left">
                                    <div class="flex items-center">
                                        <div class="font-medium">Order Types</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="filter.order_type" :value="filter.order_type"
                                    :options="{
                                        placeholder: 'Select Order Type',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(type, index) in orderTypes"
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
                                        <div class="font-medium">Products</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="filter.product" :value="filter.product"
                                    :options="{
                                        placeholder: 'Select Product',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(product, index) in products"
                                        :key="index"
                                        :value="product.id"
                                    >
                                        {{ product.name }}
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
                                        <div class="font-medium">Branches</div>
                                    </div>
                                </div>
                            </FormLabel>
                            <div class="flex-1 w-full mt-3 xl:mt-0">
                                <TomSelect
                                    v-model="filter.product" :value="filter.product"
                                    :options="{
                                        placeholder: 'Select Branch',
                                      }"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(branch, index) in branches"
                                        :key="index"
                                        :value="branch.id"
                                    >
                                        {{ branch.name }}
                                    </option>
                                </TomSelect>

                            </div>
                        </FormInline>
                    </div>
                </div>
            </div>
            <!-- END: Settings -->
            <div class="flex flex-col justify-end gap-2 mt-5 md:flex-row">
                <Button variant="primary" type="button" class="w-full py-3 md:w-52" @click="getReport()">
                    Apply
                </Button>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div
            class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap"
        >
            <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <FormInput
                        type="text"
                        class="w-56 pr-10 !box"
                        placeholder="Search..."
                        v-model="search"
                        @keypress.enter="getReport()"
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
            <Table class="border-spacing-y-[10px] border-separate mt-2">
                <Table.Thead>
                    <Table.Tr>
                        <Table.Th class="border-b-0 whitespace-nowrap">  Name </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap">  Phone </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Type </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Total </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Status </Table.Th>
                        <Table.Th class="border-b-0 whitespace-nowrap"> Date </Table.Th>
                        <Table.Th class="text-center border-b-0 whitespace-nowrap">
                            ACTIONS
                        </Table.Th>
                    </Table.Tr>
                </Table.Thead>
                <Table.Tbody>
                    <Table.Tr 
                        v-for="(record, index) in  records.data"
                        :key="index"
                        class="intro-x"
                    >
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ record.customer_name }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ record.phone_number }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ record.order_type }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ record.total }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{ record.status }}
                            </span>
                        </Table.Td>
                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b]"
                        >
                            <span href="" class="font-medium whitespace-nowrap">
                                {{dateFormat(record.created_at) }}
                            </span>
                        </Table.Td>

                        <Table.Td
                            class="first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 dark:bg-darkmode-600 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400"
                        >
                            <div class="flex items-center justify-center">
                                <RouterLink :to="{name : 'order.details', params:{'id' : record.id} }"
                                            class="flex items-center mr-3">
                                    <Lucide icon="CheckSquare" class="w-4 h-4 mr-1"/>
                                    View Details
                                </RouterLink>
                            </div>
                        </Table.Td>
                    </Table.Tr>
                </Table.Tbody>
            </Table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div v-if="records.per_page !== undefined"
            class="flex flex-wrap items-center col-span-12 intro-y sm:flex-row sm:flex-nowrap"
        >
            <Pagination class="w-full sm:w-auto sm:mr-auto">
                <Pagination.Link @click="getProducts(records.first_page_url)">
                    <Lucide icon="ChevronsLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="records.prev_page_url" @click="getProducts(records.prev_page_url)">
                    <Lucide icon="ChevronLeft" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link v-if="records.current_page - 1 > 1">...</Pagination.Link>
                <Pagination.Link  v-if="records.prev_page_url" @click="getProducts(records.prev_page_url)">{{records.current_page - 1}}</Pagination.Link>
                <Pagination.Link active>{{records.current_page}}</Pagination.Link>
                <Pagination.Link  v-if="records.next_page_url" @click="getProducts(records.next_page_url)">{{records.current_page + 1}}</Pagination.Link>
                <Pagination.Link v-if="records.last_page - records.current_page > 1">...</Pagination.Link>
                <Pagination.Link v-if="records.next_page_url" @click="getProducts(records.next_page_url)">
                    <Lucide icon="ChevronRight" class="w-4 h-4" />
                </Pagination.Link>
                <Pagination.Link @click="getProducts(records.last_page_url)">
                    <Lucide icon="ChevronsRight" class="w-4 h-4" />
                </Pagination.Link>
            </Pagination>
            <label>Page Size</label>
            <select class="disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-darkmode-800/50 [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800/50 transition duration-200 ease-in-out text-sm border-slate-200 shadow-sm rounded-md py-2 px-3 pr-8 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 w-20 mt-3 !box sm:mt-0" v-model="records.per_page">
                <option v-for="page in limits" :value="page">{{page}}</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>
</template>
