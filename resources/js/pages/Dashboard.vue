<script setup lang="ts">
import _ from "lodash";
import {ref, provide, onMounted, reactive, watch, onActivated, onUpdated} from "vue";
import fakerData from "../utils/faker";
import Button from "../base-components/Button";
import Pagination from "../base-components/Pagination";
import { FormInput, FormSelect } from "../base-components/Form";
import TinySlider, { TinySliderElement } from "../base-components/TinySlider";
import Lucide from "../base-components/Lucide";
import Tippy from "../base-components/Tippy";
import Litepicker from "../base-components/Litepicker";
import ReportDonutChart from "../components/ReportDonutChart";
import ReportLineChart from "../components/ReportLineChart";
import ReportPieChart from "../components/ReportPieChart";
import VerticalBarChart from "../components/VerticalBarChart";
import SimpleLineChart1 from "../components/SimpleLineChart1";
import ReportMap from "../components/ReportMap";
import { Menu } from "../base-components/Headless";
import Table from "../base-components/Table";
import axios from "axios";
import dayjs from "dayjs";

const salesReportFilter = ref<string>("");
const importantNotesRef = ref<TinySliderElement>();
const data = reactive({
    stats:{},
    statsPerDates:{},
    statsPerDay:{},
    statsPerHour:{},
    statsPerWeek:{},
    salesStats:{},
    orderStats:{},
    branchStats:{},
    dealStats:{},
    categoryStats:{},
    productStats:{},
    costStats:{},
    orderStatusStats:{},
    loading:true
});
const reports = {
    'statsPerDates' : 'dates',
    'statsPerDay' : 'day',
    'statsPerHour' : 'hour' ,
    'salesStats' : 'sales',
    'orderStats' : 'orders',
    'branchStats' : 'branches',
    'dealStat' : 'deals',
    'categoryStats' : 'category',
    'productsStats' : 'product',
    'costStats' : 'cost',
    'orderStatusStats' : 'orderStatus'
}
const start_date = ref<string>("");
const end_date = ref<string>("");
const loadedData =  reactive({
    statsPerDates:false,
    statsPerDay:false,
    statsPerHour:false,
    statsPerWeek:false,
    salesStats:false,
    orderStats:false,
    branchStats:false,
    dealStats:false,
    categoryStats:false,
    productStats:false,
    costStats:false,
    orderStatusStats:false,
});
provide("bind[importantNotesRef]", (el: TinySliderElement) => {
    importantNotesRef.value = el;
});
watch(salesReportFilter, async (newSalesReportFilter) => {
    loadData(newSalesReportFilter);
    $.each(reports, function(key,value){
        loadMoreData(start_date.value , end_date.value , value , key);
    });
});
const prevImportantNotes = () => {
    importantNotesRef.value?.tns.goTo("prev");
};
const nextImportantNotes = () => {
    importantNotesRef.value?.tns.goTo("next");
};
const loadData = ((reportFilter) => {
    data.loading = true;
    const dates = reportFilter.split('-');
    const format = "YYYY-MM-D HH:mm:ss";
    start_date.value = dayjs(dates[0]).subtract(2,'month').format(format);
    end_date.value = dayjs(dates[1]).add(1,'day').format(format);
    axios.get('/api/report/dashboard-stats',{params : {'start_date' : start_date.value , 'end_date' :end_date.value}}).then((response)=>{
        data.stats = response.data.stats;
    }).catch( (error) => {
        console.log(error.response.data.message)
    });
    data.loading = false;
    
});
const getAvgOrderAmount = (() => {
    if(data.stats.total_sale == undefined || data.stats.total_orders == undefined)
        return 0;
    if(data.stats.total_sale == 0 || data.stats.total_orders == 0)
        return 0;
    return Math.round(data.stats.total_sale/data.stats.total_orders);
});

const loadMoreData = ((start_date , end_date , type , key) => {
    axios.get('/api/report/dashboard-stats',{params : {'start_date' : start_date , 'end_date' :end_date, 'type' : type}}).then((response)=>{
        data[key] = response.data.stats;
        loadedData[key] = true
    }).catch( (error) => {
        console.log(error.response.data.message);
        return {};
    });
    data.loading = false;

})
const dateFormat = ((date) => {
    return dayjs(date)
        .format("DD MMMM YYYY");
})
</script>

<template>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="flex items-center h-10 intro-y">
                        
                        <div class="items-center block h-10 intro-y sm:flex">
                            <h2 class="mr-5 text-lg font-medium truncate">General Report</h2>
                        <div class="relative mt-3 sm:ml-auto sm:mt-0 text-slate-500">
                            <Lucide
                                icon="Calendar"
                                class="absolute inset-y-0 left-0 z-10 w-4 h-4 my-auto ml-3"
                            />
                            <Litepicker
                                v-model="salesReportFilter"
                                :options="{
                  autoApply: false,
                  singleMode: false,
                  numberOfColumns: 2,
                  numberOfMonths: 2,
                  showWeekNumbers: true,
                  dropdowns: {
                    minYear: 1990,
                    maxYear: null,
                    months: true,
                    years: true,
                  },
                }"
                                class="pl-10 sm:w-56 !box"
                            />
                        </div>
                    </div>
                        <a v-on:click="loadData(salesReportFilter)" class="flex items-center ml-auto text-primary">
                            <Lucide icon="RefreshCcw" class="w-4 h-4 mr-3" /> Reload Data
                        </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5" v-if="!data.loading">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div
                                :class="[
                  'relative zoom-in',
                  'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                ]"
                            >
                                <div class="p-5 box">
                                    <div class="flex">
                                        <Lucide
                                            icon="ShoppingCart"
                                            class="w-[28px] h-[28px] text-primary"
                                        />
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ data.stats.total_sale  !== undefined ?  data.stats.total_sale : 0 }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Sale</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div
                                :class="[
                  'relative zoom-in',
                  'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                ]"
                            >
                                <div class="p-5 box">
                                    <div class="flex">
                                        <Lucide
                                            icon="CreditCard"
                                            class="w-[28px] h-[28px] text-pending"
                                        />
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ data.stats.total_orders !== undefined ? data.stats.total_orders : 0 }}</div>
                                    <div class="mt-1 text-base text-slate-500">Total Orders</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div
                                :class="[
                  'relative zoom-in',
                  'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                ]"
                            >
                                <div class="p-5 box">
                                    <div class="flex">
                                        <Lucide
                                            icon="Monitor"
                                            class="w-[28px] h-[28px] text-warning"
                                        />
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ getAvgOrderAmount() }}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Avg Order Amount
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                            <div
                                :class="[
                  'relative zoom-in',
                  'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                ]"
                            >
                                <div class="p-5 box">
                                    <div class="flex">
                                        <Lucide
                                            icon="Monitor"
                                            class="w-[28px] h-[28px] text-warning"
                                        />
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ data.stats.top_product !== undefined ? data.stats.top_product : 'N/A' }}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Top Product
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 lg:col-span-12" v-if="loadedData.statsPerDates" >
                    
                    <div class="p-5 mt-12 intro-y box sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div
                                        class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl"
                                    >
                                        Records From {{ dateFormat(start_date) }} - {{ dateFormat(end_date) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            :class="[
                'relative',
                'before:content-[\'\'] before:block before:absolute before:w-16 before:left-0 before:top-0 before:bottom-0 before:ml-10 before:mb-7 before:bg-gradient-to-r before:from-white before:via-white/80 before:to-transparent before:dark:from-darkmode-600',
                'after:content-[\'\'] after:block after:absolute after:w-16 after:right-0 after:top-0 after:bottom-0 after:mb-7 after:bg-gradient-to-l after:from-white after:via-white/80 after:to-transparent after:dark:from-darkmode-600',
              ]"
                        >
                            <ReportLineChart :height="275" :label="'No. of orders'"  class="mt-6 -mb-6" :data=data.statsPerDates />
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 mt-8 sm:col-span-12 lg:col-span-4" v-if="loadedData.statsPerDay">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">Daily Report</h2>
                    </div>
                    <div class="p-5 mt-5 intro-y box">
                        <div class="mt-3">
                            <ReportPieChart :height="275" :label="'No Of Orders'" :data="data.statsPerDay" />
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 sm:col-span-12 lg:col-span-8" v-if="loadedData.statsPerHour">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">Hourly Report</h2>
                    </div>
                    <div class="p-5 mt-5 intro-y box">
                        <div class="mt-3">
                            <VerticalBarChart :height="275" :label="'No Of Orders'" :data="data.statsPerHour" />
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
            </div>
        </div>
    </div>
</template>
