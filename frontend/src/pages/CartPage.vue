<script setup>

    import 'vue3-carousel/carousel.css'
    import RelatedProduct from '../components/RelatedProduct.vue'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import { ref } from 'vue'
    import StarRating from 'vue-star-rating'

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
        itemsToShow: 1,
        gap: 5,
        wrapAround: true,
        autoplay: 4000,
        pauseAutoplayOnHover: true,
    }

    const rating = ref(0)
    const qty = ref(1)
    const price = 980.00
    const total = ref(price)
    const tabActive = ref(2)

    function setQty(type){
        if (type === '+') {
            qty.value = qty.value + 1
            total.value = price * qty.value
        } else {
            if (qty.value > 1) {
                qty.value = qty.value - 1
                total.value = price  * qty.value
            }
        }
    }
    
    function setTabActive(e, i) {
        e.preventDefault();
        e.stopImmediatePropagation();
        tabActive.value = i
    }
    
</script>
<template>
    <main class="flex-shrink-0 p-3 border-bottom bg-gray text-uppercase mb-5" id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-3">
       <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <Carousel v-bind="config">
                        <Slide v-for="image in images" :key="image.id">
                            <img :src="image.url"  class='card-img-top' alt='' />
                        </Slide>
                        <template #addons>
                            <Navigation />
                            <Pagination />
                        </template>
                    </Carousel>
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bolder text-uppercase">Product Name Goes Here</h3>
                     <div class='clearfix mt-3 mb-1'>
                        <div class="small text-warning mb-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <a href='#' class='text-decoration-none'><small>10 Review(s) | Add your review</small></a>
                     </div>
                    <strong class='text-danger me-2'>${{ price }}</strong><del><strong class='text-muted'>$990.00</strong></del><strong class='text-danger ms-2'>IN STOCK</strong>
                    <p class='mt-2'>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class='clearfix mt-2'>
                        <button  class="btn btn-light border me-1">
                            <i class="bi bi-heart me-1"></i>
                        </button>
                        <button  class="btn btn-light border me-1">
                            <i class="bi bi-currency-exchange me-1"></i>
                        </button>
                        <button  class="btn btn-light border me-1">
                            <i class="bi bi-eye me-1"></i>
                        </button>
                    </div>
                    <div class='mt-4 text-uppercase'>
                        <span class='text-muted d-inline'>Category :</span>
                        <a class='d-inline ms-1 text-decoration-none' href="#">Headphones </a>
                        <a class='d-inline ms-1 text-decoration-none' href="#">Accessories </a>
                    </div>
                    <div class='text-uppercase mt-2'>
                        <small class='text-muted d-inline'>Share :</small>
                        <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-facebook ms-1"></i></a>
                        <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-twitter ms-1"></i></a>
                        <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-google ms-1"></i></a>
                        <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-instagram ms-1"></i></a>
                    </div>
                    <form class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Size <span class="text-danger">*</span></label>
                                    <select class="form-control">
                                        <option value="0" selected disabled>Please Select Size</option>
                                        <option>11 to 12 inches</option>
                                        <option>13 to 14 inches</option>
                                        <option>15 to 16 inches</option>
                                        <option>17 to 18 inches</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Colour <span class="text-danger">*</span></label>
                                    <select class="form-control">
                                        <option value="0" selected disabled>Please Select Colour</option>
                                        <option>Blue</option>
                                        <option>Red</option>
                                        <option>Blue</option>
                                        <option>Green</option>
                                        <option>Yellow</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Qty <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <button class="btn btn-danger" type="button" @click="setQty('-')">
                                           <i class="bi bi-bag-dash"></i>
                                        </button>
                                        <input readonly type="number" class="form-control text-center" :value="qty">
                                        <button class="btn btn-success" type="button" @click="setQty('+')">
                                           <i class="bi bi-bag-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-danger">$ Total </label>
                                    <input readonly type="text" class="form-control text-end" :value="total">
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary text-white w-100 mt-4" href="#"><i class="bi bi-cart-plus mb-1 me-1"></i>Add To Cart</a>
                    </form>
                </div>
            </div>
       </div>
    </main>
    <main class="flex-shrink-0 mt-5 mb-3">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-12">
                    <ul class="nav nav-underline">
                        <li class="nav-item">
                            <a class="nav-link" @click="(event) => setTabActive(event, 0)" :class="tabActive === 0 ? 'active' : ''" aria-current="page" href="#">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" @click="(event) => setTabActive(event, 1)" :class="tabActive === 1 ? 'active' : ''" href="#">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" @click="(event) => setTabActive(event, 2)" :class="tabActive === 2 ? 'active' : ''" href="#">Reviews (3)</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane container" :class="tabActive === 0 ? 'active p-0' : ''">
                            <p class='mt-3'>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                                cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                                cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                        <div class="tab-pane container" :class="tabActive === 1 ? 'active p-0' : ''">
                            <p class='mt-3'>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                                cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                                cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                                cillum dolore eu fugiat nulla pariatur. 
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                        <div class="tab-pane container" :class="tabActive === 2 ? 'active p-0' : ''">
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="clearfix">
                                        <h4 class='d-inline me-3'>4.5</h4>
                                        <div class="d-inline text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                        </div>
                                    </div>
                                    <div class="clearfix mt-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width:70%">70%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width:80%">80%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width:70%">70%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width:60%">60%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                    <i class="bi bi-star"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width:50%">50%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong class='d-block'>John Doe</strong>
                                            <small class='small'>27 DEC 2018, 8:0 PM</small>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong class='d-block'>John Doe</strong>
                                            <small class='small'>27 DEC 2018, 8:0 PM</small>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong class='d-block'>John Doe</strong>
                                            <small class='small'>27 DEC 2018, 8:0 PM</small>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <form>
                                        <input type="text" placeholder='Your Name' class="form-control mb-2"/>
                                        <input type="text" placeholder='Your E-Mail Address' class="form-control mb-2"/>
                                        <textarea class="form-control mb-2" placeholder="Your Review" rows="3"></textarea>
                                        <StarRating v-model:rating="rating" :star-size="20" :show-rating="false" />
                                        <button class="btn btn-primary text-white w-100 mt-3">
                                            <i class="bi bi-telegram mb-1 me-1"></i> Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="section-title text-center">
                    <h3 class="title">Related Products</h3>
                </div>
                <div class="slider-container text-center">
                    <RelatedProduct />
                </div>
            </div>
        </div>
    </main>
</template>