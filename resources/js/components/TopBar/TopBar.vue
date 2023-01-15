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
export default defineComponent({
    data() {
        return {
            user : useUserStore().getUser()
        };
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

    <!-- END: Notifications  -->
    <!-- BEGIN: Account Menu -->
    <Menu>
      <Menu.Button
        class="block w-8 h-8 overflow-hidden rounded-full shadow-lg image-fit zoom-in intro-x"
      >
        <img
          alt="Midone Tailwind HTML Admin Template"
          :src="user.profile && user.profile.avatar !== null ? '/images/avatar/'+user.profile.avatar : '/images/avatar/profile-2.jpg'"
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
