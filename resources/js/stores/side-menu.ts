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
            icon: "User",
            pageName: "users",
            title: "Users",
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
      },
      {
        icon: "MessageSquare",
        pageName: "categories",
        title: "Categories",
      },
        {
            icon: "MessageSquare",
            pageName: "deals",
            title: "Deals",
        },
        {
            icon: "FileText",
            pageName: 'addons',
            title: "Addons",
        },
      {
        icon: "FileText",
        pageName: 'products',
        title: "Products",
      },
      // "devider",
      // {
      //   icon: "Edit",
      //   pageName: "side-menu-crud",
      //   title: "Crud",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-crud-data-list",
      //       title: "Data List",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-crud-form",
      //       title: "Form",
      //     },
      //   ],
      // },
      // {
      //   icon: "Users",
      //   pageName: "side-menu-users",
      //   title: "Users",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-users-layout-1",
      //       title: "Layout 1",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-users-layout-2",
      //       title: "Layout 2",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-users-layout-3",
      //       title: "Layout 3",
      //     },
      //   ],
      // },
      // {
      //   icon: "Trello",
      //   pageName: "side-menu-profile",
      //   title: "Profile",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-profile-overview-1",
      //       title: "Overview 1",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-profile-overview-2",
      //       title: "Overview 2",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-profile-overview-3",
      //       title: "Overview 3",
      //     },
      //   ],
      // },
      // {
      //   icon: "Layout",
      //   pageName: "side-menu-layout",
      //   title: "Pages",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-wizards",
      //       title: "Wizards",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-wizard-layout-1",
      //           title: "Layout 1",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-wizard-layout-2",
      //           title: "Layout 2",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-wizard-layout-3",
      //           title: "Layout 3",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-blog",
      //       title: "Blog",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-blog-layout-1",
      //           title: "Layout 1",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-blog-layout-2",
      //           title: "Layout 2",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-blog-layout-3",
      //           title: "Layout 3",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-pricing",
      //       title: "Pricing",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-pricing-layout-1",
      //           title: "Layout 1",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-pricing-layout-2",
      //           title: "Layout 2",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-invoice",
      //       title: "Invoice",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-invoice-layout-1",
      //           title: "Layout 1",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-invoice-layout-2",
      //           title: "Layout 2",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-faq",
      //       title: "FAQ",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-faq-layout-1",
      //           title: "Layout 1",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-faq-layout-2",
      //           title: "Layout 2",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-faq-layout-3",
      //           title: "Layout 3",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "login",
      //       title: "Login",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "register",
      //       title: "Register",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "error-page",
      //       title: "Error Page",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-update-profile",
      //       title: "Update profile",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-change-password",
      //       title: "Change Password",
      //     },
      //   ],
      // },
      // "devider",
      // {
      //   icon: "Inbox",
      //   pageName: "side-menu-components",
      //   title: "Components",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-table",
      //       title: "Table",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-regular-table",
      //           title: "Regular Table",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-tabulator",
      //           title: "Tabulator",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-overlay",
      //       title: "Overlay",
      //       subMenu: [
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-modal",
      //           title: "Modal",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-slide-over",
      //           title: "Slide Over",
      //         },
      //         {
      //           icon: "Zap",
      //           pageName: "side-menu-notification",
      //           title: "Notification",
      //         },
      //       ],
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-tab",
      //       title: "Tab",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-accordion",
      //       title: "Accordion",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-button",
      //       title: "Button",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-alert",
      //       title: "Alert",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-progress-bar",
      //       title: "Progress Bar",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-tooltip",
      //       title: "Tooltip",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-dropdown",
      //       title: "Dropdown",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-typography",
      //       title: "Typography",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-icon",
      //       title: "Icon",
      //     },
      //     {
      //       icon: "Zap",
      //       pageName: "side-menu-loading-icon",
      //       title: "Loading ",
      //     },
      //   ],
      // },
      // {
      //   icon: "Sidebar",
      //   pageName: "side-menu-forms",
      //   title: "Forms",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-regular-form",
      //       title: "Regular Form",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-datepicker",
      //       title: "Datepicker",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-tom-select",
      //       title: "Tom Select",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-file-upload",
      //       title: "File Upload",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-wysiwyg-editor",
      //       title: "Wysiwyg Editor",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-validation",
      //       title: "Validation",
      //     },
      //   ],
      // },
      // {
      //   icon: "HardDrive",
      //   pageName: "side-menu-widgets",
      //   title: "Widgets",
      //   subMenu: [
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-chart",
      //       title: "Chart",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-slider",
      //       title: "Slider",
      //     },
      //     {
      //       icon: "Activity",
      //       pageName: "side-menu-image-zoom",
      //       title: "Image Zoom",
      //     },
      //   ],
      // },
    ],
  }),
});
