<script setup>

    import 'vue3-carousel/carousel.css'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import services from '../services'
    import { ref, inject } from 'vue'

    const swal = inject('$swal')
    const props = defineProps(['loadOrder', 'products'])
    const config = {
        itemsToShow: 3.5,
        gap: 5,
        wrapAround: true,
        autoplay: 3000,
        pauseAutoplayOnHover: true,
    }

    const loadingSubmitWhishlist = ref(false)
    const whishlist = ref(0)
    const logged = localStorage.getItem('auth_token') !== null && localStorage.getItem('auth_user') !== null

    function addWhishlist(id){
        whishlist.value = id
        loadingSubmitWhishlist.value = true
        setTimeout(() => { 
            services.order.wishlist(id).then((result) => { 
                loadingSubmitWhishlist.value = false
                whishlist.value = 0
                props.loadOrder()
                swal.fire({
                    title: "Success !!",
                    text: result.data.message,
                    icon: "success"
                });
            })
            .catch((error) => {
                console.log(error)
                loadingSubmitWhishlist.value = false
                const msg = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
                swal.fire({
                    title: "Failed !!",
                    text: msg,
                    icon: "error"
                });
            });
        }, 1500)
    }

</script>



<template>
    <div class="slider-container text-center">
        <Carousel v-bind="config">
            <Slide v-for="product in products" :key="product.id">
                <div class="card me-2">
                    <template v-if="product.newest">
                        <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-30%</div>
                        <div class="badge bg-danger text-white position-absolute product-label rounded-0" style="right:3.5rem" >NEW</div>
                    </template>
                    <template v-if="product.discount">
                        <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-50%</div>
                    </template>
                    <img :src="product.image" alt="image" />
                    <h5 class='text-primary'>{{ product.category }}</h5>  
                    <h6 class="fw-bolder">{{ product.name }}</h6>
                    <strong class='text-danger me-2'>$ {{ product.price }}</strong><del><strong class='text-muted'>$ {{ product.price_old }}</strong></del>
                    <div class="d-flex justify-content-center small text-warning">
                        <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                        <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                    </div>
                    <div class="clearfix text-center mt-2 mb-4">
                        <button v-if="logged" class="btn btn-light border me-1" @click="addWhishlist(product.id)">
                            <i :class="loadingSubmitWhishlist && product.id === whishlist ? 'fas fa-circle-notch fa-spin disabled' : 'bi bi-heart'"></i>
                        </button>
                        <button class="btn btn-light border me-1">
                            <i class="bi bi-currency-exchange"></i>
                        </button>
                        <button class="btn btn-light border me-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </Slide>
            <template #addons>
                <Navigation />
                <Pagination />
            </template>
        </Carousel>
    </div>
</template>