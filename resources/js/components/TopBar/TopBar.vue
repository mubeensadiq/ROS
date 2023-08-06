<script setup lang="ts">
import { ref } from "vue";
import Lucide from "../../base-components/Lucide";
import Breadcrumb from "../../base-components/Breadcrumb";
import { FormInput } from "../../base-components/Form";
import { Menu, Popover } from "../../base-components/Headless";
import fakerData from "../../utils/faker";
import _ from "lodash";
import { TransitionRoot } from "@headlessui/vue";
const searchDropdown = ref(false);
const showSearchDropdown = () => {
  searchDropdown.value = true;
};
const hideSearchDropdown = () => {
  searchDropdown.value = false;
};
</script>
<script lang="ts">
import { useUserStore } from "../../stores/users";
import {defineComponent} from "vue";
import axios from "axios";
export default defineComponent({
    data() {
        return {
            user : JSON.parse(localStorage.getItem('user')),
            profile : JSON.parse(localStorage.getItem('profile'))
        };
    },
    mounted(){
      let recaptchaScript = document.createElement('script')
      recaptchaScript.setAttribute('src', '/js/push-notifications.js')
      document.head.appendChild(recaptchaScript)
    },
    methods: {
        async logout() {
            const userStore = useUserStore();
            await userStore.logout();
        }
    },
});
</script>
<template>
  <!-- BEGIN: Top Bar -->
  <div
    class="h-[67px] z-[51] flex items-center relative border-b border-slate-200"
  >
    <!-- BEGIN: Breadcrumb -->
    <Breadcrumb class="hidden mr-auto -intro-x sm:flex">
      <Breadcrumb.Link to="/">Application</Breadcrumb.Link>
      <Breadcrumb.Link to="/" :active="true"> Dashboard </Breadcrumb.Link>
    </Breadcrumb>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
    <div class="relative mr-3 intro-x sm:mr-6">
      <div class="relative hidden sm:block">
        <FormInput
          type="text"
          class="border-transparent w-56 shadow-none rounded-full bg-slate-300/50 pr-8 transition-[width] duration-300 ease-in-out focus:border-transparent focus:w-72 dark:bg-darkmode-400/70"
          placeholder="Search..."
          @focus="showSearchDropdown"
          @blur="hideSearchDropdown"
        />
        <Lucide
          icon="Search"
          class="absolute inset-y-0 right-0 w-5 h-5 my-auto mr-3 text-slate-600 dark:text-slate-500"
        />
      </div>
      <a class="relative text-slate-600 sm:hidden" href="">
        <Lucide icon="Search" class="w-5 h-5 dark:text-slate-500" />
      </a>
    </div>
    <!-- END: Search  -->
    <!-- BEGIN: Notifications -->
    <div class="relative mr-auto intro-x sm:mr-6">
      <div onclick="enableNotifications('/enable-notifications')" class="cursor-pointer relative text-slate-600 outline-none block" id="headlessui-popover-button-1" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 w-5 h-5 dark:text-slate-500"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
      </div>
    </div>
    <!-- END: Notifications  -->
    <!-- BEGIN: Account Menu -->
    <Menu>
      <Menu.Button
        class="block w-8 h-8 overflow-hidden rounded-full shadow-lg image-fit zoom-in intro-x"
      >
        <img
          alt="Midone Tailwind HTML Admin Template"
          :src="profile && profile.avatar !== null ? '/images/avatar/'+profile.avatar : '/images/avatar/default.png'"
        />
      </Menu.Button>
      <Menu.Items class="w-56 mt-px text-white bg-primary">
        <Menu.Header class="font-normal">
          <div class="font-medium">{{ user.full_name }}</div>
          <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">
            {{ user.email }}
          </div>
        </Menu.Header>
        <Menu.Devider class="bg-white/[0.08]" />
        <Menu.Item class="hover:bg-white/5">
          <Lucide icon="User" class="w-4 h-4 mr-2" /> Profile
        </Menu.Item>
        <Menu.Item class="hover:bg-white/5">
          <Lucide icon="Lock" class="w-4 h-4 mr-2" /> Reset Password
        </Menu.Item>
        <Menu.Devider class="bg-white/[0.08]" />
        <Menu.Item class="hover:bg-white/5" @click="logout()">
          <Lucide icon="ToggleRight" class="w-4 h-4 mr-2" /> Logout
        </Menu.Item>
      </Menu.Items>
    </Menu>
  </div>
  <!-- END: Top Bar -->
</template>
