<script setup lang="ts">
import Lucide from "../base-components/Lucide";
import Notification from "../base-components/Notification";
import { NotificationElement } from "../base-components/Notification";
import Button from "../base-components/Button";
import { ref, provide } from "vue";
const props = defineProps(['toastText' , 'toastType'])
// Basic non sticky notification
const basicNonStickyNotification = ref<NotificationElement>();
const basicNonStickyNotificationToggle = () => {
    // Show notification
    basicNonStickyNotification.value?.showToast();
};

provide("bind[basicNonStickyNotification]", (el: NotificationElement) => {
    basicNonStickyNotification.value = el;
});
</script>

<template>
    <Notification refKey="basicNonStickyNotification" :options="{
                    duration: 2000,
                  }" class="flex flex-col sm:flex-row">
        <Lucide v-if="toastType === 'success'" icon="CheckCircle" class="text-success" />
        <Lucide v-if="toastType === 'error'" icon="XCircle" class="text-danger" />
        <div class="ml-4 mr-4">
            <div class="font-medium">{{toastText}}</div>
        </div>
    </Notification>
    <Button  @click="basicNonStickyNotificationToggle"
             variant="danger"
             type="button"
             class="w-24 hidden"
             id="toastBtn"
    >
        Show Toast
    </Button>
</template>
