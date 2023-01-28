<script setup lang="ts">
import _ from "lodash";
import { ref, provide } from "vue";
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
import ReportDonutChart1 from "../components/ReportDonutChart1";
import SimpleLineChart1 from "../components/SimpleLineChart1";
import ReportMap from "../components/ReportMap";
import { Menu } from "../base-components/Headless";
import Table from "../base-components/Table";

const salesReportFilter = ref<string>("");
const importantNotesRef = ref<TinySliderElement>();

provide("bind[importantNotesRef]", (el: TinySliderElement) => {
  importantNotesRef.value = el;
});

const prevImportantNotes = () => {
  importantNotesRef.value?.tns.goTo("prev");
};
const nextImportantNotes = () => {
  importantNotesRef.value?.tns.goTo("next");
};
</script>

<template>
</template>
