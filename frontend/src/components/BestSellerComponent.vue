<script setup>

    import 'vue3-carousel/carousel.css'
    import { Carousel, Slide } from 'vue3-carousel'

    const images = [
        {
            id: 1,
            url: "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png"
        },
        {
            id: 2,
            url: "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png"
        },
        {
            id: 3,
            url: "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png"
        }
    ]

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
                <div class="card me-2 p-4 rounded-0 border-0 d-block" v-for="image in images" :key="image.id">
                    <div class="card-body clearfix">
                        <div class="float-start">
                            <img :src="image.url" class="img img-responsive text-center" width="120"  alt="image" />
                        </div>
                        <div class="float-end">
                            <h5 class='text-primary'>CATEGORY</h5>  
                            <h6 class="fw-bolder">Product Name Goes Here</h6>
                            <strong class='text-danger me-2'>$980.00</strong><del><strong class='text-muted'>$990.00</strong></del>
                            <div class='clearfix text-warning'>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
            </Slide>
        </Carousel>
    </div>
</template>