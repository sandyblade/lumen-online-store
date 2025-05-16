<script setup>

    defineProps({ products: Array })

    import 'vue3-carousel/carousel.css'
    import { Carousel, Slide } from 'vue3-carousel'

   

    const config = {
        itemsToShow: 1,
        gap: 5,
        wrapAround: true,
        autoplay: 3000,
        pauseAutoplayOnHover: true,
    }


</script>

<style scoped>
    .carousel__slide {
        display: block !important;
    }
</style>



<template>
    <div class="slider-container best-seller-container">
        <Carousel v-bind="config">
            <Slide>
                <div class="card me-2 p-4 rounded-0 border-0 d-block" v-for="product in products" :key="product.id">
                    <div class="card-body clearfix">
                        <div class="float-start">
                            <img :src="product.image" class="img img-responsive text-center" width="120"  alt="image" />
                        </div>
                        <div class="float-end">
                            <h5 class='text-primary'>{{ product.category }}</h5>  
                            <h6 class="fw-bolder">{{ product.name }}</h6>
                            <strong class='text-danger me-2'>$ {{ product.price }}</strong><del><strong class='text-muted'>$ {{ product.price_old }}</strong></del>
                            <div class='clearfix text-warning'>
                                <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
            </Slide>
        </Carousel>
    </div>
</template>