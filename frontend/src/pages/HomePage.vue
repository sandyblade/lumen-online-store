<script setup>

    import Shimmer from "vue3-loading-shimmer"
    import { ref, onMounted } from 'vue'
    import SliderComponent from '../components/SliderComponent.vue'
    import BestSellerComponent from '../components/BestSellerComponent.vue'  
    import services from '../services';
    

    const loading = ref(true)
    const categories = ref([])
    const products = ref([])
    const topSellings = ref([])
    const bestSellers = ref([])
    const activeTab1 = ref(0)
    const activeTab2 = ref(0)
    const props = defineProps(['loadOrder', 'setting'])
    

    async function loadData(){
        loading.value = true
        await services.home.page()
            .then((response) => {
                setTimeout(() => { 
                    const data = response.data
                    categories.value = data.categories
                    products.value = data.products
                    topSellings.value = data.topSellings
                    bestSellers.value = data.bestSellers
                    loading.value = false
                    activeTab1.value = data.categories[0].id
                    activeTab2.value = data.categories[0].id
                }, 1500)
            }).catch((error) => {
            console.log(error)
       })
    }

    function setTab1(e, index) {
        e.preventDefault();
        e.stopImmediatePropagation()
        activeTab1.value = index
    }

    function setTab2(e, index){
        e.preventDefault();
        e.stopImmediatePropagation()
        activeTab2.value = index
    }
    
    onMounted(() => {
        loadData()
    })

    
</script>
<template>
   <main class="flex-shrink-0">
      <div class="container">
          <div v-if="loading" class="row mt-5">
             <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
          </div>
          <div v-else class="row mt-5">
              <div class="col-md-4" v-for="category in categories">
                  <div class="shop">
                      <div class="shop-img">
                         <img :src="category.image" alt="" />
                      </div>
                      <div class="shop-body">
                        <h3 class="d-block">{{ category.name }}</h3>
                        <h3 class="d-block">Collection</h3>
                        <router-link :to="`store?category=${category.id}`" class="cta-btn">
                            <i class="bi bi-arrow-right-circle me-1"></i>Shop now
                        </router-link>
                      </div>
                  </div>
              </div>
          </div>
      </div>
   </main>
   <main class="flex-shrink-0" id="products">
      <div class="container p-3" v-if="loading">
         <div class="row">
            <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
         </div>
      </div>
      <div class="container p-3"  v-else>
        <div class="row">
            <div class="col-md-12 mb-2">
                <div class="section-title">
                    <h3 class="title">New Products</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li v-for="category in categories" :class="activeTab1 === category.id ? 'active' : ''">
                                <a data-toggle="tab" href="#" @click="(event) => setTab1(event, category.id)" class='text-decoration-none'>
                                    {{ category.name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>  
            <div class="col-md-12">
                <SliderComponent :products="products" :loadOrder="loadOrder" />
            </div>
        </div>
      </div>    
   </main>
   <main class="flex-shrink-0" v-if="loading">
        <div class="container p-3">
            <div class="row">
                <div class="col-md-12">
                    <Shimmer style="height: 20rem; border-radius: 5px;" />
                </div>
            </div>
      </div>
   </main>
   <main v-else class="flex-shrink-0 border" id="hot-deal">
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
                         <router-link to="store" class="bg-primary btn w-25 mt-1 text-white">
                            <i class="bi bi-cart 'mb-1 me-1"></i>Shop now
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
   </main>
   <main class="flex-shrink-0" id="top-selling">
      <div class="container p-3" v-if="loading">
          <div class="row">
            <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-3">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
         </div>  
      </div>
      <div class="container p-3" v-else>
        <div class="row">
            <div class="col-md-12 mb-2">
                <div class="section-title">
                    <h3 class="title">Top Selling</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li v-for="category in categories" :class="activeTab2 === category.id ? 'active' : ''">
                                <a data-toggle="tab" href="#" @click="(event) => setTab2(event, category.id)" class='text-decoration-none'>
                                    {{ category.name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <SliderComponent :products="topSellings" :loadOrder="loadOrder" />
            </div>
        </div>
      </div>    
   </main>
   <main class="flex-shrink-0 mt-5" id="best-seller">
      <div class="container p-3">
         <div class="row mb-4" v-if="loading">
            <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
             <div class="col-md-4">
                 <Shimmer style="height: 20rem; border-radius: 5px;" />
             </div>
         </div>
         <div class="row" v-else>
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent :products="bestSellers" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent :products="bestSellers" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="section-title text-center">
                    <h5 class="title">Best Seller</h5>
                </div>
                <div class="slider-container">
                    <BestSellerComponent :products="bestSellers" />
                </div>
            </div>
         </div>
      </div>
   </main>
</template>