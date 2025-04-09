<script setup>
    import SliderComponent from '../components/SliderComponent.vue'
    import BestSellerComponent from '../components/BestSellerComponent.vue'
</script>
<template>
   <main class="flex-shrink-0">
      <div class="container">
          <div class="row mt-5">
              <div class="col-md-4">
                  <div class="shop">
                      <div class="shop-img">
                         <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop01.png" alt="" />
                      </div>
                      <div class="shop-body">
                         <h3 class="d-block">Laptop</h3>
                         <h3 class="d-block">Collection</h3>
                         <a href="#" class="cta-btn"><i class="bi bi-arrow-right-circle me-1"></i>Shop now</a>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="shop">
                      <div class="shop-img">
                         <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop03.png" alt="" />
                      </div>
                      <div class="shop-body">
                         <h3 class="d-block">Accessories</h3>
                         <h3 class="d-block">Collection</h3>
                         <a href="#" class="cta-btn"><i class="bi bi-arrow-right-circle me-1"></i>Shop now</a>
                      </div>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="shop">
                      <div class="shop-img">
                         <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/shop02.png" alt="" />
                      </div>
                      <div class="shop-body">
                         <h3 class="d-block">Cameras</h3>
                         <h3 class="d-block">Collection</h3>
                         <a href="#" class="cta-btn"><i class="bi bi-arrow-right-circle me-1"></i>Shop now</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
   </main>
   <main class="flex-shrink-0" id="products">
      <div class="container p-3">
        <div class="row">
            <div class="col-md-12 mb-2">
                <div class="section-title">
                    <h3 class="title">New Products</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li><a data-toggle="tab" href="#tab2" class='text-decoration-none'>Laptops</a></li>
                            <li class="active"><a data-toggle="tab" href="#" class='text-decoration-none'>Smartphones</a></li>
                            <li><a data-toggle="tab" href="#" class='text-decoration-none'>Cameras</a></li>
                            <li><a data-toggle="tab" href="#" class='text-decoration-none'>Accessories</a></li>
                        </ul>
                    </div>
                </div>
            </div>  
            <div class="col-md-12">
                <SliderComponent />
            </div>
        </div>
      </div>    
   </main>
   <main class="flex-shrink-0 border" id="hot-deal">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hot-deal">
                    <ul class="hot-deal-countdown">
                        <li>
                            <div>
                                <h3>02</h3>
                                <span>Days</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>10</h3>
                                <span>Hours</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>34</h3>
                                <span>Mins</span>
                            </div>
                        </li>
                        <li>
                            <div>
                                <h3>60</h3>
                                <span>Secs</span>
                            </div>
                        </li>
                    </ul>
                    <h2 class="text-uppercase">hot deal this week</h2>
                    <p>New Collection Up to 50% OFF</p>
                    <a class="bg-primary btn w-25 mt-1 text-white" href="#"><i class="bi bi-cart 'mb-1 me-1"></i>Shop now</a>
                </div>
            </div>
        </div>
    </div>
   </main>
   <main class="flex-shrink-0" id="top-selling">
      <div class="container p-3">
        <div class="row">
            <div class="col-md-12 mb-2">
                <div class="section-title">
                    <h3 class="title">Top Selling</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li><a data-toggle="tab" href="#tab2" class='text-decoration-none'>Laptops</a></li>
                            <li class="active"><a data-toggle="tab" href="#" class='text-decoration-none'>Smartphones</a></li>
                            <li><a data-toggle="tab" href="#" class='text-decoration-none'>Cameras</a></li>
                            <li><a data-toggle="tab" href="#" class='text-decoration-none'>Accessories</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <SliderComponent />
            </div>
        </div>
      </div>    
   </main>
   <main class="flex-shrink-0 mt-5" id="best-seller">
      <div class="container p-3">
         <div class="row">
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent/>
                </div>
            </div>
         </div>
      </div>
   </main>
</template>