<script setup lang="ts">
import { useRoute } from "vue-router";
import logoUrl from "../../assets/images/logo.svg";
import Devider from "./Devider.vue";
import Menu from "./Menu.vue";
import TopBar from "../../components/TopBar";
import DarkModeSwitcher from "../../components/DarkModeSwitcher";
import MobileMenu from "../../components/MobileMenu";
import { useSideMenuStore } from "../../stores/side-menu";
import { FormattedMenu, nestedMenu, enter, leave } from "./side-menu";
import { watch, reactive, computed, onMounted } from "vue";

const route = useRoute();
let formattedMenu = reactive<Array<FormattedMenu | "devider">>([]);
const setFormattedMenu = (
  computedFormattedMenu: Array<FormattedMenu | "devider">
) => {
  Object.assign(formattedMenu, computedFormattedMenu);
};
const sideMenuStore = useSideMenuStore();
const sideMenu = computed(() => nestedMenu(sideMenuStore.menu, route));

watch(sideMenu, () => {
  setFormattedMenu(sideMenu.value);
});

onMounted(() => {
  setFormattedMenu(sideMenu.value);
});
</script>

<template>
  <div class="py-2">
      <DarkModeSwitcher />
    <MobileMenu />
    <div class="flex mt-[4.7rem] md:mt-0">
      <!-- BEGIN: Side Menu -->
      <nav
        class="pr-5 pb-16 overflow-x-hidden hidden md:block w-[85px] xl:w-[230px]"
      >
        <RouterLink
          :to="{ name: 'dashboard' }"
          class="flex items-center pt-4 pl-5 intro-x"
        >
          <img
            alt="Midone Tailwind HTML Admin Template"
            class="w-6"
            :src="logoUrl"
          />
          <span class="hidden ml-3 text-lg text-white xl:block"> Pizza Xpress </span>
        </RouterLink>
        <Devider type="div" class="my-6"></Devider>
        <ul>
          <!-- BEGIN: First Child -->
          <template v-for="(menu, menuKey) in formattedMenu">
            <Devider
              v-if="menu == 'devider'"
              type="li"
              :class="[
                'my-6',

                // Animation
                `opacity-0 animate-[0.4s_ease-in-out_0.1s_intro-devider] animate-fill-mode-forwards animate-delay-${
                  (menuKey + 1) * 10
                }`,
              ]"
              :key="'devider-' + menuKey"
            ></Devider>
            <li v-else :key="menuKey">
              <Menu v-if="$can(menu.pageName)"
                :class="{
                  // Animation
                  [`opacity-0 translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] animate-fill-mode-forwards animate-delay-${
                    (menuKey + 1) * 10
                  }`]: !menu.active,
                }"
                :menu="menu"
                :formattedMenuState="[formattedMenu, setFormattedMenu]"
                level="first"
              ></Menu>
              <!-- BEGIN: Second Child -->
              <Transition @enter="enter" @leave="leave">
                <ul
                  v-if="menu.subMenu && menu.activeDropdown"
                  class="rounded-lg bg-black/10 dark:bg-darkmode-900/30"
                >
                  <li
                    v-for="(subMenu, subMenuKey) in menu.subMenu"
                    :key="subMenuKey"
                  >
                    <Menu
                      :class="{
                        // Animation
                        [`opacity-0 translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] animate-fill-mode-forwards animate-delay-${
                          (subMenuKey + 1) * 10
                        }`]: !subMenu.active,
                      }"
                      :menu="subMenu"
                      :formattedMenuState="[formattedMenu, setFormattedMenu]"
                      level="second"
                    ></Menu>
                    <!-- BEGIN: Third Child -->
                    <Transition
                      @enter="enter"
                      @leave="leave"
                      v-if="subMenu.subMenu"
                    >
                      <ul
                        v-if="subMenu.subMenu && subMenu.activeDropdown"
                        class="rounded-lg bg-black/10 dark:bg-darkmode-900/30"
                      >
                        <li
                          v-for="(
                            lastSubMenu, lastSubMenuKey
                          ) in subMenu.subMenu"
                          :key="lastSubMenuKey"
                        >
                          <Menu
                            :class="{
                              // Animation
                              [`opacity-0 translate-x-[50px] animate-[0.4s_ease-in-out_0.1s_intro-menu] animate-fill-mode-forwards animate-delay-${
                                (lastSubMenuKey + 1) * 10
                              }`]: !lastSubMenu.active,
                            }"
                            :menu="lastSubMenu"
                            :formattedMenuState="[
                              formattedMenu,
                              setFormattedMenu,
                            ]"
                            level="third"
                          ></Menu>
                        </li>
                      </ul>
                    </Transition>
                    <!-- END: Third Child -->
                  </li>
                </ul>
              </Transition>
              <!-- END: Second Child -->
            </li>
          </template>
          <!-- END: First Child -->
        </ul>
      </nav>
      <!-- END: Side Menu -->
      <!-- BEGIN: Content -->
      <div
        class="rounded-[30px] min-w-0 min-h-screen flex-1 pb-10 bg-slate-100 dark:bg-darkmode-700 px-4 md:px-[22px] max-w-full md:max-w-auto before:content-[''] before:w-full before:h-px before:block"
      >
        <TopBar />
        <RouterView />
      </div>
      <!-- END: Content -->
    </div>
  </div>
</template>
