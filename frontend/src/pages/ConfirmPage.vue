<script setup>

    import { ref, onMounted } from 'vue'
    import { Vue3Lottie } from 'vue3-lottie'
    import CheckingJSON from '../animations/checking.json'
    import ConfirmedJSON from '../animations/confirmed.json'
    import service from '../services'
    import { useRoute, useRouter  } from 'vue-router'

    const loading = ref(true)
    const nowYear = new Date().getFullYear()
    const route = useRoute()
    const errorResponse = ref('')

    onMounted(() => {
        let token = route.params.token
        service.auth.confirm(token)
        .then(() => {
            loading.value = false
        })
        .catch((error) => {
            loading.value = false
            errorResponse.value = error.response.data?.message
        });
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
                           <div v-if="errorResponse">
                                <Vue3Lottie :animationData="CheckingJSON"  />
                                <div class="alert alert-danger">
                                    <span>{{ errorResponse }}</span>
                                </div>
                           </div>
                           <div v-else>
                                <Vue3Lottie :animationData="ConfirmedJSON"  />
                                <div class="alert alert-success">
                                    <small>Your registration is complete. Now you can login</small>
                                </div>
                                <router-link to="/auth/login" class="btn btn-primary mt-3 w-100">
                                    <i class="bi-box-arrow-right me-2"></i>Please login here.
                                </router-link>
                           </div>
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