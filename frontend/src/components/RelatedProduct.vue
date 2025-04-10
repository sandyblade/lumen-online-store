<script setup>

    import 'vue3-carousel/carousel.css'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

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
        },
        {
            id: 4,
            url: "https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product04.png"
        }
    ]

    const config = {
        itemsToShow: 3.5,
        gap: 5,
        wrapAround: true,
        autoplay: 3000,
        pauseAutoplayOnHover: true,
    }


</script>



<template>
    <div class="slider-container text-center">
        <Carousel v-bind="config">
            <Slide v-for="image in images" :key="image.id">
                <div class="card me-2">
                    <template v-if="image.id === 2">
                        <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-30%</div>
                        <div class="badge bg-danger text-white position-absolute product-label rounded-0" style="right:3.5rem" >NEW</div>
                    </template>
                    <template v-if="image.id === 4">
                        <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-50%</div>
                    </template>
                    <img :src="image.url" alt="image" />
                    <div class="card-body p-4">
                        <h5 class='text-primary'>CATEGORY</h5>  
                        <h6 class="fw-bolder">Product Name Goes Here</h6>
                        <strong class='text-danger me-2'>$980.00</strong><del><strong class='text-muted'>$990.00</strong></del>
                        <div class="d-flex justify-content-center small text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="clearfix text-center mt-2">
                            <button class="btn btn-light border me-1">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="btn btn-light border me-1">
                                <i class="bi bi-currency-exchange"></i>
                            </button>
                            <button class="btn btn-light border me-1">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary w-100 mt-4">
                            <i class="bi bi-cart-plus me-1"></i> Add To Cart
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