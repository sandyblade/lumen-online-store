<script setup>

    import { Vue3Lottie } from 'vue3-lottie'
    import LoaderJSON from './animations/loader.json'
    import AppComponent from './components/AppComponent.vue'
    import { ref, onMounted } from 'vue'
    
    const loading = ref(true)
    const connected = ref(false)
    
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
   <template v-if="loading">
      <main class="flex-shrink-0 p-3 mb-5">
        <div class="container loader-section">
          <div class="row">
            <div class="col-md-5 mt-5 mx-auto">
              <Vue3Lottie :animationData="LoaderJSON"  />
            </div>
          </div>
        </div>
    </main>
   </template>
  <template v-else>
      <template v-if="!connected">
          <main class="flex-shrink-0 p-3 mb-5 error-section">
            <div class="d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <h1 class="display fw-bold text-muted text-error-code"><i class="bi bi-wifi-off"></i></h1>
                    <p class="fs-3"> <span class="text-danger">Opps!</span> Disconnected from server</p>
                    <div class="lead">
                        Sorry, An Http error has occurred. Please close the client and try again.
                    </div>
                </div>
            </div>
        </main>
      </template>
      <template v-else>
          <AppComponent />
      </template>
  </template>
</template>
