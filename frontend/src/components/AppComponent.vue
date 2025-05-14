<script setup>

    import { useWindowScroll } from '@vueuse/core'
    import HeaderComponent from './HeaderComponent.vue'
    import FooterComponent from './FooterComponent.vue'
    import NavbarComponent from './NavbarComponent.vue'
    import NewsletterComponent from './NewsletterComponent.vue'
    import { ref, onMounted } from 'vue'
    import service from '../services'

    const { y } = useWindowScroll({ behavior: 'smooth' })
    const categories = ref([])
    const setting = ref({})

    function clickToTop(event){
        const e = event
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        e.stopImmediatePropagation();
    }

    onMounted(async () => {
        await service.home.component()
            .then((result) => {
                const data = result.data
                categories.value = data.categories
                setting.value = data.setting
            })
            .catch((error) => {
                console.log(error)
            })
    })

</script>
<template>
    <HeaderComponent  :categories="categories" />
    <NavbarComponent :categories="categories" />
    <router-view />
    <NewsletterComponent />
    <FooterComponent />
    <a @click="clickToTop" v-if="y > 300" href="#" class="btn btn-lg btn-primary back-to-top">
        <i class="bi bi-chevron-up"></i>
    </a>
</template>