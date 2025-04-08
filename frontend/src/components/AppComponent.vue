<script setup>
    import HeaderComponent from './HeaderComponent.vue'
    import FooterComponent from './FooterComponent.vue'
    import NavbarComponent from './NavbarComponent.vue'
    import NewsletterComponent from './NewsletterComponent.vue'
</script>
<template>
    <HeaderComponent />
    <NavbarComponent />
    <router-view />
    <NewsletterComponent />
    <FooterComponent />
</template>