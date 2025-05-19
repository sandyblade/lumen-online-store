import { createWebHistory, createRouter } from "vue-router";
import AppComponent from "./components/AppComponent.vue"
import CartPage from "./pages/CartPage.vue"
import CheckoutPage from "./pages/CheckoutPage.vue"
import ConfirmPage from "./pages/ConfirmPage.vue"
import ErrorPage from "./pages/ErrorPage.vue"
import ForgotPasswordPage from "./pages/ForgotPasswordPage.vue"
import HomePage from "./pages/HomePage.vue"
import LoginPage from "./pages/LoginPage.vue"
import PasswordPage from "./pages/PasswordPage.vue"
import ProfilePage from "./pages/ProfilePage.vue"
import RegisterPage from "./pages/RegisterPage.vue"
import ResetPasswordPage from "./pages/ResetPasswordPage.vue"
import StorePage from "./pages/StorePage.vue"
import OrderPage from "./pages/OrderPage.vue";
import OrderDetailPage from "./pages/OrderDetailPage.vue";

const logged = localStorage.getItem('auth_token') !== null && localStorage.getItem('auth_user') !== null

const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage,
        meta: { layout: AppComponent },
    },
    {
        path: "/order",
        name: "Order",
        props: { loadOrder: null, setting: null },
        component: logged ? OrderPage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/order/:id",
        name: "OrderDetail",
        props: { loadOrder: null, setting: null },
        component: logged ? OrderDetailPage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/checkout/:id",
        name: "Checkout",
        props: { loadOrder: null, setting: null },
        component: logged ? CheckoutPage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/cart/:id",
        name: "Cart",
        props: { loadOrder: null, setting: null },
        component: logged ? CartPage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/",
        name: "Home",
        props: { loadOrder: null },
        component: HomePage,
        meta: { layout: AppComponent },
    },
    {
        path: "/auth/register/confirm/:token",
        name: "Confirm",
        component: ConfirmPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "Error",
        component: ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/auth/email/forgot",
        name: "ForgotPassword",
        component: ForgotPasswordPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/auth/login",
        name: "Login",
        component: LoginPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/account/password",
        name: "AccountPassword",
        component: logged ? PasswordPage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/account/profile",
        name: "AccountProfile",
        component: logged ? ProfilePage : ErrorPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/auth/register",
        name: "Register",
        component: RegisterPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/auth/email/reset/:token",
        name: "ResetPassword",
        component: ResetPasswordPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/store",
        name: "Store",
        props: { loadOrder: null, setting: null },
        component: logged ? StorePage : ErrorPage,
        meta: { layout: AppComponent },
    },
]

const router = createRouter({ history: createWebHistory(), routes });

router.beforeEach(async (to, from) => {
    let authRoutes = ["Confirm", "ForgotPassword", "Login", "ResetPassword", "Register"]
    let routeName = to.name
    if (authRoutes.includes(routeName)) {
        if (localStorage.getItem('auth_token')) {
            router.push('/')
            setTimeout(() => { location.reload() })
        }
    }
})

export default router;