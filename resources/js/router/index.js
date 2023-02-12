import { createRouter, createWebHistory } from "vue-router";
import SideMenu from "../layouts/SideMenu/SideMenu.vue";
import Dashboard from "../pages/Dashboard.vue";
import Users from "../pages/Users.vue";
import AddUser from "../pages/AddUser.vue";
import Riders from "../pages/Riders.vue";
import AddRider from "../pages/AddRider.vue";
import Roles from "../pages/Roles.vue";
import AddRole from "../pages/AddRole.vue";
import Cities from "../pages/Cities.vue";
import AddCity from "../pages/AddCity.vue";
import Areas from "../pages/Areas.vue";
import AddArea from "../pages/AddArea.vue";
import Branches from "../pages/Branches.vue";
import AddBranch from "../pages/AddBranch.vue";
import UpdateBranch from "../pages/AddBranch.vue";
import Categories from "../pages/Categories.vue";
import AddCategory from "../pages/AddCategory.vue";
import Addons from "../pages/Addons.vue";
import AddAddon from "../pages/AddAddon.vue";
import Products from "../pages/Products.vue";
import ProductGrid from "../pages/ProductGrid.vue";
import AddProduct from "../pages/AddProduct.vue";
import Login from "../pages/Login.vue";
import Home from "../pages/Home.vue";
import Confirmation from "../pages/Confirmation.vue";
import Checkout from "../pages/Checkout.vue";
import { useUserStore } from "../stores/users";
const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/confirm",
        name: "Confirmation",
        component: Confirmation,
    },
    {
        path: "/checkout",
        name: "Checkout",
        component: Checkout,
    },
    {
        path: "/admin",
        component: SideMenu,
        children: [
        {
            path: "home",
            name: "dashboard",
            component: Dashboard,
        },
        {
            path: "users",
            name: "users",
            component: Users
        },
        {
            path: "users/create",
            name: "users.create",
            component: AddUser
        },
        {
            path: "user/update/:id",
            name: "users.update",
            component: AddUser,
        },
        {
            path: "riders",
            name: "riders",
            component: Riders
        },
        {
            path: "riders/create",
            name: "riders.create",
            component: AddRider
        },
        {
            path: "rider/update/:id",
            name: "riders.update",
            component: AddRider,
        },
        {
            path: "roles",
            name: "roles",
            component: Roles
        },
        {
            path: "roles/create",
            name: "roles.create",
            component: AddRole
        },
        {
            path: "role/update/:id",
            name: "roles.update",
            component: AddRole,
        },
        {
            path: "cities",
            name: "cities",
            component: Cities,
        },
        {
            path: "cities/update/:id",
            name: "cities.update",
            component: AddCity,
        },
        {
            path: "cities/create",
            name: "cities.create",
            component: AddCity,
        },
        {
            path: "areas",
            name: "areas",
            component: Areas,
        },
        {
            path: "areas/create",
            name: "areas.create",
            component: AddArea,
        },
        {
            path: "areas/update/:id",
            name: "areas.update",
            component: AddArea,
        },
        {
            path: "Categories",
            name: "categories",
            component: Categories,
        },
        {
            path: "categories/create",
            name: "categories.create",
            component: AddCategory,
        },
        {
            path: "categories/update/:id",
            name: "categories.update",
            component: AddCategory,
        },
        {
            path: "branches",
            name: "branches",
            component: Branches,
        },
        {
            path: "branches/create",
            name: "branches.create",
            component: AddBranch,
        },
        {
            path: "branches/update/:id",
            name: "branches.update",
            component: UpdateBranch,
        },
        {
            path: "addons",
            name: "addons",
            component: Addons,
        },
        {
            path: "addon/create",
            name: "addons.create",
            component: AddAddon,
        },
        {
            path: "addon/update/:id",
            name: "addons.update",
            component: AddAddon,
        },

        {
            path: "products",
            name: "products",
            component: Products,
        },
        {
            path: "products/create",
            name: "products.create",
            component: AddProduct,
        },
        {
            path: "product/update/:id",
            name: "products.update",
            component: AddProduct,
        },
    ],
  },
  {
    path: "/login",
    name: "login",
    component: Login,
  }

];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 };
  },
});

router.beforeEach(async (to,from ,next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login' ,'/','/confirm','/checkout'];
    const authRequired = !publicPages.includes(to.path);
    const auth = useUserStore();
    if(authRequired){
        if (!auth.user) {
            next({ name: 'login' });
        }
        if(auth.user && Permissions.length === 0){
            next({ name: 'login' });
        }
        if( Permissions.indexOf(to.name) !== -1 || publicPages.includes(to.path)){
            next();
        }
        else{
            next({ name: Permissions[0] });
        }
    }
    else{
        if(auth.user && to.name === 'login' && Permissions.length !== 0){
            next({ name: 'dashboard' });
        }

        next();
    }


});

export default router;
