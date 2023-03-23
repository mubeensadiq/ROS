<script setup lang="ts">
import _ from "lodash";
import Button from "../base-components/Button";
import Table from "../base-components/Table";
import axios from "axios";
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()
import { ref, reactive , onMounted } from "vue";
import dayjs from "dayjs";
const data = reactive({ order: null})
onMounted(() => {
    getOrderDetails();
})
const dateFormat = ((date) => {
    return dayjs(date)
        .format("DD MMMM YYYY");
})
const getOrderDetails = ((url = '/api/order-details/'+route.params.id) => {
    axios.get(url).then((response)=>{
        if(response.data.order != undefined)
            data.order = response.data.order;
    }).catch( (error) => {
        console.log(error);
    });
});

</script>

<template>
  <div class="flex flex-col items-center mt-8 intro-y sm:flex-row">
    <h2 class="mr-auto text-lg font-medium">ORDER DETAILS</h2>
    <div class="flex w-full mt-4 sm:w-auto sm:mt-0">
      <Button variant="primary" class="mr-2 shadow-md"> Print </Button>
    </div>
  </div>
  <!-- BEGIN: Invoice -->
  <div class="mt-5 overflow-hidden intro-y box" v-if="data.order">
    <div
      class="flex flex-col px-5 pt-5 text-center border-b lg:flex-row sm:px-20 sm:pb-10 sm:text-left"
    >
      <div>
        <div class="text-3xl font-semibold text-primary">CUSTOMER DETAILS</div>
        <div class="mt-2">
          {{data.order.customer_name}}
        </div>
        <div class="mt-1">{{data.order.phone_number}}</div>
        <div class="mt-1">{{data.order.delivery_address}}</div>
      </div>
      <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
        <div class="text-3xl font-semibold text-primary">ORDER NUMBER</div>
        <div class="mt-2 text-lg">#{{data.order.order_number}}</div>
        <div class="mt-1">{{dateFormat(data.order.created_at)}}</div>
      </div>
    </div>
    <div class="px-5 sm:px-16 sm:py-10">
      <div class="overflow-x-auto">
        <Table>
          <Table.Thead>
            <Table.Tr>
              <Table.Th
                class="border-b-2 dark:border-darkmode-400 whitespace-nowrap"
              >
                Product
              </Table.Th>
              <Table.Th
                class="text-right border-b-2 dark:border-darkmode-400 whitespace-nowrap"
              >
                QTY
              </Table.Th>
              <Table.Th
                class="text-right border-b-2 dark:border-darkmode-400 whitespace-nowrap"
              >
                PRICE
              </Table.Th>
              <Table.Th
                class="text-right border-b-2 dark:border-darkmode-400 whitespace-nowrap"
              >
                SUBTOTAL
              </Table.Th>
            </Table.Tr>
          </Table.Thead>
          <Table.Tbody>
            <Table.Tr  v-for="product in data.order.products">
              <Table.Td class="border-b dark:border-darkmode-400">
                <div class="font-medium whitespace-nowrap">
                  {{product.product_name}}
                </div>
                  <template v-if="product.addons.length > 0">
                      <div v-for="addon in product.addons" class="text-slate-500 text-sm mt-0.5 whitespace-nowrap" >
                        {{addon.quantity}} x {{addon.name}} (Rs . {{addon.price}})
                      </div>
                  </template>

              </Table.Td>
              <Table.Td
                class="w-32 text-right border-b dark:border-darkmode-400"
              >
                  {{product.quantity}}
              </Table.Td>
              <Table.Td
                class="w-32 text-right border-b dark:border-darkmode-400"
              >
                  {{product.price}}
              </Table.Td>
              <Table.Td
                class="w-32 font-medium text-right border-b dark:border-darkmode-400"
              >
                  {{product.quantity*product.price}}
              </Table.Td>
            </Table.Tr>
          </Table.Tbody>
        </Table>
      </div>
    </div>
    <div class="flex flex-col-reverse px-5 pb-10 sm:px-20 sm:pb-20 sm:flex-row">
      <div class="text-center sm:text-right sm:ml-auto">
        <div class="text-base text-slate-500">Sub Total: <span class="text-primary">Rs {{data.order.sub_total}}</span></div>
          <div class="text-base text-slate-500">Tax Amount: <span class="text-primary">Rs {{data.order.tax}}</span></div>
          <div class="text-base text-slate-500">Total Amount: <span class="text-primary">Rs {{data.order.total}}</span></div>
      </div>
    </div>
  </div>
  <!-- END: Invoice -->
</template>
