<script setup>

    import { useWindowScroll } from '@vueuse/core'
    import HeaderComponent from './HeaderComponent.vue'
    import FooterComponent from './FooterComponent.vue'
    import NavbarComponent from './NavbarComponent.vue'
    import NewsletterComponent from './NewsletterComponent.vue'
    import { ref, onMounted } from 'vue'
    import services from '../services'

    const { y } = useWindowScroll({ behavior: 'smooth' })
    const categories = ref([])
    const setting = ref({})
    const order = ref({})
    const wishlist = ref([])
    const cart = ref([])
    const loading = ref(true)
    const isAuth = localStorage.getItem('auth_token') !== null && localStorage.getItem('auth_user') !== null

    function clickToTop(event){
        const e = event
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        e.stopImmediatePropagation();
    }

    async function loadData(){
        loading.value = true
        await services.home.component()
            .then((response) => {
                const data = response.data
                categories.value = data.categories
                setting.value = data.setting
                loading.value = false
            }).catch((error) => {
            console.log(error)
       })
    }

    async function loadOrder(){
        await services.order.product()
            .then((response) => {
                const data = response.data
                cart.value = data.cart
                wishlist.value = data.wishlist
                order.value = data.order
            }).catch((error) => {
            console.log(error)
       })
    }

    onMounted(() => {
        loadData()
        if (isAuth) {
            loadOrder()
        }
    })

</script>
<template>
    <HeaderComponent v-if="loading === false" :categories="categories" :wishlist="wishlist" :cart="cart" :order="order" :loadOrder="loadOrder" />
    <NavbarComponent v-if="loading === false" :categories="categories" />
    <router-view v-if="loading === false" :loadOrder="loadOrder" :setting="setting" />
    <NewsletterComponent v-if="loading === false" />
    <FooterComponent v-if="loading === false" :categories="categories"  :setting="setting" />
    <a @click="clickToTop" v-if="y > 300 && loading === false" href="#" class="btn btn-lg btn-primary back-to-top">
        <i class="bi bi-chevron-up"></i>
    </a>
</template>