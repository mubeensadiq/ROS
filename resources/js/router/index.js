import { createRouter, createWebHistory } from "vue-router";
import SideMenu from "../layouts/SideMenu/SideMenu.vue";
import Dashboard from "../pages/Dashboard.vue";
import Users from "../pages/Users.vue";
import AddUser from "../pages/AddUser.vue";
import Cities from "../pages/Cities.vue";
import Areas from "../pages/Areas.vue";
import AddArea from "../pages/AddArea.vue";
import Branches from "../pages/Branches.vue";
import AddBranch from "../pages/AddBranch.vue";
import UpdateBranch from "../pages/AddBranch.vue";
import Categories from "../pages/Categories.vue";
import AddCategory from "../pages/AddCategory.vue";
import Deals from "../pages/Deals.vue";
import AddDeal from "../pages/AddDeal.vue";
import Addons from "../pages/Addons.vue";
import AddAddon from "../pages/AddAddon.vue";
import ProductList from "../pages/ProductList.vue";
import ProductGrid from "../pages/ProductGrid.vue";
import AddProduct from "../pages/AddProduct.vue";
import Login from "../pages/Login.vue";
import { useUserStore } from "../stores/users";
const routes = [
  {
    path: "/",
    component: SideMenu,
    children: [
        {
            path: "/",
            name: "dashboard",
            component: Dashboard,
        },
        {
            path: "users",
            name: "users",
            component: Users
        },
        {
            path: "/users/create",
            name: "createUser",
            component: AddUser
        },
        {
            path: "cities",
            name: "cities",
            component: Cities,
        },
        {
            path: "areas",
            name: "areas",
            component: Areas,
        },
        {
            path: "/areas/create",
            name: "createArea",
            component: AddArea,
        },
        {
            path: "Categories",
            name: "categories",
            component: Categories,
        },
        {
            path: "/categories/create",
            name: "createCategory",
            component: AddCategory,
        },
        {
            path: "Deals",
            name: "deals",
            component: Deals,
        },
        {
            path: "/deals/create",
            name: "createDeal",
            component: AddDeal,
        },
        {
            path: "Branches",
            name: "branches",
            component: Branches,
        },
        {
            path: "/branches/create",
            name: "createBranch",
            component: AddBranch,
        },
        {
            path: "/branches/update/:id",
            name: "editBranch",
            component: UpdateBranch,
        },
        {
            path: "Addons",
            name: "addons",
            component: Addons,
        },
        {
            path: "/addon/create",
            name: "createAddon",
            component: AddAddon,
        },


        {
            path: "products",
            name: "products",
            component: ProductList,
        },
        {
            path: "/products/create",
            name: "createProduct",
            component: AddProduct,
        },
        {
            path: "product-grid",
            name: "product-grid",
            component: ProductGrid,
        },
    ],
  },
  {
    path: "/login",
    name: "login",
    component: Login,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 };
  },
});

router.beforeEach(async (to) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);
    const auth = useUserStore();
    if (authRequired && !auth.user) {
        auth.returnUrl = to.fullPath;
        return '/login';
    }
});

export default router;
