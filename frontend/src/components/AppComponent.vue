<script setup>

    import { useWindowScroll } from '@vueuse/core'
    import HeaderComponent from './HeaderComponent.vue'
    import FooterComponent from './FooterComponent.vue'
    import NavbarComponent from './NavbarComponent.vue'
    import NewsletterComponent from './NewsletterComponent.vue'

    const { y } = useWindowScroll({ behavior: 'smooth' })

    function clickToTop(event){
        const e = event
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        e.stopImmediatePropagation();
    }

</script>
<template>
    <HeaderComponent />
    <NavbarComponent />
    <router-view />
    <NewsletterComponent />
    <FooterComponent />
    <a @click="clickToTop" v-if="y > 300" href="#" class="btn btn-lg btn-primary back-to-top">
        <i class="bi bi-chevron-up"></i>
    </a>
</template>