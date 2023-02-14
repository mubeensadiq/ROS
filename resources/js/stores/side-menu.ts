import { defineStore } from "pinia";
import { Icon } from "../base-components/Lucide/Lucide.vue";

export interface Menu {
  icon: Icon;
  title: string;
  pageName?: string;
  subMenu?: Menu[];
  ignore?: boolean;
}

export interface SideMenuState {
  menu: Array<Menu | "devider">;
}

export const useSideMenuStore = defineStore("sideMenu", {
  state: (): SideMenuState => ({
    menu: [
        {
            icon: "Home",
            pageName: "dashboard",
            title: "Dashboard"
        },
        {
            icon: "FileText",
            pageName: 'products',
            title: "Products",
        },
        {
            icon: "MessageSquare",
            pageName: "categories",
            title: "Categories",
        },
        {
            icon: "FileText",
            pageName: "addon.categories",
            title: "Addon Categories",
        },
        {
            icon: "FileText",
            pageName: 'addons',
            title: "Addons",
        },

        {
            icon: "User",
            pageName: "riders",
            title: "Riders",
        },
        {
            icon: "User",
            pageName: "users",
            title: "Users",
        },
        {
            icon: "User",
            pageName: "roles",
            title: "Roles",
        },

        {
            icon: "Activity",
            pageName: "cities",
            title: "Cities",
        },
        {
            icon: "HardDrive",
            pageName: "areas",
            title: "Areas",
        },
        {
            icon: "CreditCard",
            pageName: "branches",
            title: "Branches",
        }
    ],
  }),
});
