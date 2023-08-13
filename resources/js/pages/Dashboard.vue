<script setup lang="ts">
import _ from "lodash";
import {ref, provide, onMounted, reactive, watch, onActivated, onUpdated} from "vue";
import Lucide from "../base-components/Lucide";
import Litepicker from "../base-components/Litepicker";
import ReportDonutChart from "../components/ReportDonutChart";
import ReportLineChart from "../components/ReportLineChart";
import ReportPieChart from "../components/ReportPieChart";
import VerticalBarChart from "../components/VerticalBarChart";
import axios from "axios";
import dayjs from "dayjs";

const salesReportFilter = ref<string>("");
const data = reactive({
    stats:{},
    statsPerDates:{},
    statsPerDay:{},
    statsPerHour:{},
    orderStats:{},
    branchStats:{},
    areaStats:{},
    dealStats:{},
    categoryStats:{},
    productsStats:{},
    orderStatusStats:{},
    loading:true
});
const reports = {
    'statsPerDates' : 'dates',
    'statsPerDay' : 'day',
    'statsPerHour' : 'hour' ,
    'orderStatusStats' : 'orderStatus',
    'categoryStats' : 'category',
    'productsStats' : 'product',
    'branchStats' : 'branches',
    'areaStats' : 'areas',
    'orderStats' : 'orders',
    'dealStat' : 'deals'
}
const start_date = ref<string>("");
const end_date = ref<string>("");
const loadedData =  reactive({
    statsPerDates:false,
    statsPerDay:false,
    statsPerHour:false,
    orderStats:false,
    branchStats:false,
    areaStats:false,
    dealStats:false,
    categoryStats:false,
    productsStats:false,
    orderStatusStats:false,
});
watch(salesReportFilter, async (newSalesReportFilter) => {
    loadData(newSalesReportFilter);
    $.each(reports, function(key,value){
        loadMoreData(start_date.value , end_date.value , value , key);
    });
});
const loadData = ((reportFilter) => {
    data.loading = true;
    const dates = reportFilter.split('-');
    const format = "YYYY-MM-D HH:mm:ss";
    start_date.value = dayjs(dates[0]).format(format);
    end_date.value = dayjs(dates[1]).format(format);
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
const calculatePercent = ((num) => {
    let percent = ((num/data.stats.total_orders)*100);
    return percent.toFixed(2);
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
                                            icon="ShoppingCart"
                                            class="w-[28px] h-[28px] text-primary"
                                        />
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{ data.stats.total_sale_wo_dc !== undefined ? data.stats.total_sale_wo_dc : 0 }}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Total Sale W/O DC
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
                
                <!-- BEGIN: Houlry Report -->
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
                <!-- END: Hourly Report -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-4" v-if="loadedData.orderStatusStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">Order Status</h2>
                    </div>
                    <div class="p-5 mt-5 intro-y box">
                        <div class="mt-3">
                            <ReportDonutChart :height="213" :data="data.orderStatusStats" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="w-2 h-2 mr-3 rounded-full bg-primary"></div>
                                <span class="truncate">Received</span>
                                <span class="ml-auto font-medium">{{calculatePercent(data.orderStatusStats.Received)}}%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 mr-3 rounded-full bg-pending"></div>
                                <span class="truncate">Preparing</span>
                                <span class="ml-auto font-medium">{{calculatePercent(data.orderStatusStats.Preparing)}}%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                <span class="truncate">Completed</span>
                                <span class="ml-auto font-medium">{{calculatePercent(data.orderStatusStats.Completed)}}%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                <span class="truncate">Cancelled</span>
                                <span class="ml-auto font-medium">{{calculatePercent(data.orderStatusStats.Cancelled)}}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <!-- BEGIN: Top Categories -->
                <div class="col-span-12 mt-8 xl:col-span-4" v-if="loadedData.categoryStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Top 5 Categories
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div
                            v-for="(category, index) in data.categoryStats"
                            :key="index"
                            class="intro-y"
                        >
                            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">{{ category.category }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">
                                        {{ category.orders }} Orders
                                    </div>
                                </div>
                                <div
                                    class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success"
                                >
                                Sale {{ category.sale }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Top Categories -->
                <!-- BEGIN: Top Products -->
                <div class="col-span-12 mt-8 xl:col-span-4" v-if="loadedData.productsStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Top 5 Products
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div
                            v-for="(product, key) in data.productsStats"
                            :key="key"
                            class="intro-y"
                        >
                            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">{{ product.product }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">
                                        {{ product.orders }} Orders
                                    </div>
                                </div>
                                <div
                                    class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success"
                                >
                                Sale {{ product.sale }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Top Products -->
                <!-- BEGIN: Top Branches -->
                <div class="col-span-12 mt-8 xl:col-span-4" v-if="loadedData.areaStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Most Sale Areas
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div
                            v-for="(area, key) in data.areaStats"
                            :key="key"
                            class="intro-y"
                        >
                            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">{{ area.area.area }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">
                                        {{ area.orders }} Orders
                                    </div>
                                </div>
                                <div
                                    class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success"
                                >
                                Sale {{ area.sale }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Top Areas -->
                <!-- BEGIN: Top Branches -->
                <div class="col-span-12 mt-8 xl:col-span-4" v-if="loadedData.branchStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Most Sale Branches
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div
                            v-for="(branch, key) in data.branchStats"
                            :key="key"
                            class="intro-y"
                        >
                            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">{{ branch.branch.name }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">
                                        {{ branch.orders }} Orders
                                    </div>
                                </div>
                                <div
                                    class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success"
                                >
                                Sale {{ branch.sale }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Top Branches -->
                <!-- BEGIN: Top Orders -->
                <div class="col-span-12 mt-8 xl:col-span-4" v-if="loadedData.orderStats">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Top 5 Orders
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div
                            v-for="(order, key) in data.orderStats"
                            :key="key"
                            class="intro-y"
                        >
                            <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Customer: {{ order.customer_name }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">
                                        Order Number {{ order.order_number }}
                                    </div>
                                </div>
                                <div
                                    class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success"
                                >
                                Rs {{ order.total }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Top Branches -->
            </div>
        </div>
    </div>
</template>
