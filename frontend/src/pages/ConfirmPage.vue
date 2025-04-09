<script setup>

    import { ref, onMounted } from 'vue'
    import { Vue3Lottie } from 'vue3-lottie'
    import CheckingJSON from '../animations/checking.json'
    import ConfirmedJSON from '../animations/confirmed.json'

    const loading = ref(true)
    const nowYear = new Date().getFullYear()

    onMounted(() => {
        setTimeout(() => {
            loading.value = false
        }, 3000)
    })
    
</script>
<template>
    <main class="flex-shrink-0 p-3 border-bottom bg-gray text-uppercase mb-5" id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Authentication</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Account Verification</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-5">
       <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="card">
                        <div class="card-header text-center bg-primary p-2">
                            <h5 class="text-white"><i class="bi-person-check me-2"></i>Account Verification</h5>
                        </div>
                        <div class="card-body mb-2 p-4 text-center" v-if="loading">
                            <Vue3Lottie :animationData="CheckingJSON"  />
                        </div>
                        <div class="card-body mb-2 p-4 text-center" v-else>
                            <Vue3Lottie :animationData="ConfirmedJSON"  />
                            <div class="alert alert-success">
                                <small>Your registration is complete. Now you can login</small>
                            </div>
                            <router-link to="/auth/login" class="btn btn-primary mt-3 w-100">
                                <i class="bi-box-arrow-right me-2"></i>Please login here.
                            </router-link>
                        </div>
                        <div class="card-footer p-3 text-center bg-primary">
                            <span class="text-white">
                                <small>Copyright {{ nowYear }} - Elector Store</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </main>
</template>