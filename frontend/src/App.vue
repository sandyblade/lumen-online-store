<script setup>

    import { Vue3Lottie } from 'vue3-lottie'
    import LoaderJSON from './loader.json'
    import HeaderComponent from './components/HeaderComponent.vue'
    import FooterComponent from './components/FooterComponent.vue'
    import NavbarComponent from './components/NavbarComponent.vue'
    import NewsletterComponent from './components/NewsletterComponent.vue'
    import { ref, onMounted } from 'vue'
    
    const loading = ref(true)
    const connected = ref(false)
    const logged = ref(false)
    
    onMounted(() => {
        setTimeout(() => {
            loading.value = false
            connected.value = true
        }, 3000)
    })
    
</script>

<style scoped>
  .error-section{
    margin-top: 10rem;
  }
</style>


<template>
    <HeaderComponent logged="logged"  />
    <NavbarComponent logged="logged"  />
    <h1>AAAAAA</h1>
    <NewsletterComponent />
    <FooterComponent />
</template>