<script setup>
    
    import VueSlider from "vue-3-slider-component"
    import { ref } from "vue"
    
    const filterPrice = ref([100, 500])
    const totalProduct = 9

    function getCode(num){
        return (num).toString().padStart(2,"0");
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
                            <li class="breadcrumb-item"><a href="#">Store</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">

                    <h4 class='text-uppercase mb-4'>Categories</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="payment" >
                        <label class="form-check-label">
                            Laptops (120)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="payment" >
                        <label class="form-check-label">
                            Smartphones (740)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="payment" >
                        <label class="form-check-label">
                            Cameras (1450)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="payment" >
                        <label class="form-check-label">
                           Accessories (578)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="payment" >
                        <label class="form-check-label">
                           Smartphones (740)
                        </label>
                    </div>

                    <h4 class='text-uppercase mt-4 mb-4'>Price</h4>
                    <div class="mt-2  mb-4">
                        <VueSlider v-model="filterPrice" :min="0" :max="1000" adsorb />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-success fw-bold">Minimum Price ($) </label>
                        <input  type="text" class="form-control text-end" readonly :value="filterPrice[0]">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-danger fw-bold">Maximum Price ($) </label>
                        <input  type="text" class="form-control text-end" readonly :value="filterPrice[1]">
                    </div>

                    <h4 class='text-uppercase mb-4 mt-2'>Brands</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                           SAMSUNG (578)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                           LG (125)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                           SONY (755)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                           ASUS (578)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                           APPLE (125)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox">
                        <label class="form-check-label">
                            MICROSOFT (755)
                        </label>
                    </div>

                    <h4 class='text-uppercase mt-4 mb-4'>Top Selling</h4>
                    <div class="d-block">
                        <div class="card border-0 mb-2">
                            <div class="card-body clearfix">
                                <div class="float-start">
                                     <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png" class='img img-responsive text-center' width="80"  alt="image" />
                                </div>
                                <div class="float-end">
                                    <small class='text-primary d-block'>CATEGORY</small>  
                                    <small class="fw-bolder d-block">Product Name Goes Here</small>
                                    <small class='text-danger me-2'>$980.00</small><del><small class='text-muted'>$990.00</small></del>
                                    <div class="clearfix text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block">
                        <div class="card border-0 mb-2">
                            <div class="card-body clearfix">
                                <div class="float-start">
                                     <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png" class='img img-responsive text-center' width="80"  alt="image" />
                                </div>
                                <div class="float-end">
                                    <small class='text-primary d-block'>CATEGORY</small>  
                                    <small class="fw-bolder d-block">Product Name Goes Here</small>
                                    <small class='text-danger me-2'>$980.00</small><del><small class='text-muted'>$990.00</small></del>
                                    <div class="clearfix text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block">
                        <div class="card border-0 mb-2">
                            <div class="card-body clearfix">
                                <div class="float-start">
                                     <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png" class='img img-responsive text-center' width="80"  alt="image" />
                                </div>
                                <div class="float-end">
                                    <small class='text-primary d-block'>CATEGORY</small>  
                                    <small class="fw-bolder d-block">Product Name Goes Here</small>
                                    <small class='text-danger me-2'>$980.00</small><del><small class='text-muted'>$990.00</small></del>
                                    <div class="clearfix text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                               <label class="form-label fw-bold">Sort By</label>
                               <select class="form-control">
                                    <option selected>Released Date</option>
                                    <option>Rating</option>
                                    <option>Lowest Price</option>
                                    <option>Highest Price</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                               <label class="form-label fw-bold">Show</label>
                               <select class="form-control">
                                    <option selected>10 Products</option>
                                    <option>25 Products</option>
                                    <option>50 Products</option>
                                    <option>100 Products</option>
                               </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                               <label class="form-label fw-bold">Search</label>
                               <div class="input-group">
                                    <input type="text"  placeholder='Search here..' class="form-control" aria-label="Text input with dropdown button">
                                    <button class="btn btn-primary" type="button" >
                                        <span class="text-white"><i class="bi bi-search mb-1 me-1"></i>Search</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4 col-xs-6" v-for="p in totalProduct">
                            <div class="card mb-3">
                                <img :src="`https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product`+getCode(p)+`.png`" class="card-img-top" alt="" />
                                <div class="card-body p-4">
                                    <h5 class='text-primary'>CATEGORY {{ p }}</h5>  
                                    <h6 class="fw-bolder">Product Name Goes Here</h6>
                                    <strong class='text-danger me-2'>$980.00</strong><del><strong class='text-muted'>$990.00</strong></del>
                                    <div class="d-flex small text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent text-center border-top-0">
                                    <a href="#" class="btn btn-primary text-white w-100 mb-2">
                                        <i class="bi bi-cart-plus mb-1 me-1"></i>Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-9">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-3 text-end">
                            <small class='text-muted mt-2'>Showing 20-100 products</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>