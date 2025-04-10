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

const routes = [
    {
        path: "/",
        name: "Home",
        component: HomePage,
        meta: { layout: AppComponent },
    },
    {
        path: "/checkout",
        name: "Checkout",
        component: CheckoutPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/cart",
        name: "Cart",
        component: CartPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/",
        name: "Home",
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
        component: PasswordPage,
        meta: { layout: AppComponent },
    },
    {
        path: "/account/profile",
        name: "AccountProfile",
        component: ProfilePage,
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
        component: StorePage,
        meta: { layout: AppComponent },
    },
]

const router = createRouter({ history: createWebHistory(), routes });
export default router;