<script setup>

    import { Vue3BsPaginate } from 'vue3-bootstrap-paginate';
    import queryString from 'query-string'
    import Shimmer from "vue3-loading-shimmer"
    import { useRouter } from 'vue-router'
    import VueSlider from "vue-3-slider-component"
    import { ref, onMounted } from 'vue'
    import services from "../services"

    const auth_logged = localStorage.getItem('auth_token') !== null && localStorage.getItem('auth_user') !== null
    const loadingSidebar = ref(true)
    const loadingProduct = ref(true)
    const categories = ref([])
    const products = ref({})
    const brands = ref([])
    const topselling = ref([])
    const filterCategory = ref([])
    const filterBrand = ref([])
    const filterPrice = ref([100, 500])
    const sortBy = ref('published_date,desc')
    const limit = ref(9)
    const search = ref('')
    const page = ref(1)
    const router = useRouter()
    const pagination = ref(null)
    const props = defineProps(['loadOrder', 'setting'])

    function loadProduct(){

        let fCategories = filterCategory.value
        let fBrands = filterBrand.value
        let fPrices = filterPrice.value

        let params = {
            sort: sortBy.value,
            limit: limit.value,
            page: parseInt(page.value),
            price: `${fPrices.join("|")}`
        }

        if (fCategories.length > 0) {
            params = {
                ...params,
                category: `${fCategories.join(",")}`
            }
        }

        if (fBrands.length > 0) {
            params = {
                ...params,
                brand: `${fBrands.join(",")}`
            }
        }

        if (search.value) {
            params = {
                ...params,
                search: search.value
            }
        }

        loadingProduct.value = true
        const filterQueryParam = decodeURIComponent(queryString.stringify(params))
        const url = `store?${filterQueryParam}`
        router.push(url)

        setTimeout(async () => {
            await services.store.list(filterQueryParam)
            .then((response) => {
                products.value = response.data
                setTimeout(() => {
                    loadingProduct.value = false    
                }, 1500)
            })
            .catch((error) => {
                console.log(error)
            })
        }, 1500)
        
    }

    async function loadSidebar(){
        loadingSidebar.value = true
        await services.store.filter()
            .then((response) => {
                let data = response.data
                brands.value = data.brands
                categories.value = data.categories
                topselling.value = data.tops
                setTimeout(() => {
                    loadingSidebar.value = false
                }, 1500)
            })
            .catch((error) => {
                console.log(error)
            })
    }

   



    onMounted(() => {

        if (queryString.parse(location.search)) {
               
            const parsed = queryString.parse(location.search);

            if (parsed.category !== undefined){
                filterCategory.value = parsed.category.split(",")
            }

            if (parsed.price !== undefined){    
                filterPrice.value = parsed.price.split("|")
            }

            if (parsed.brand !== undefined){
                filterBrand.value = parsed.brand.split(",")
            }

            if (parsed.limit !== undefined) {
                limit.value = parsed.limit
            }

            if (parsed.page !== undefined) {
                page.value = parsed.page
            }

            if (parsed.search !== undefined) {
                search.value = parsed.search
            }

            if (parsed.sort !== undefined) {
                sortBy.value = parsed.sort
            }

        } 
        
        loadSidebar()
        loadProduct()
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


                    <div class="mb-4" v-if="loadingSidebar">
                        <Shimmer style="height: 20rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sort By</label>
                            <select class="form-control" v-model="sortBy">
                                <option value="published_date,desc">Released Date</option>
                                <option value="total_rating,desc">Rating</option>
                                <option value="price,asc">Lowest Price</option>
                                <option value="price,desc">Highest Price</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Show</label>
                            <select class="form-control" v-model="limit">
                                <option value="9">9 Products</option>
                                <option value="27">27 Products</option>
                                <option value="36">36 Products</option>
                                <option value="90">90 Products</option>
                            </select>
                        </div>
                    </div>

                    <h4 class='text-uppercase mb-4'>Categories</h4>
                    <div v-if="loadingSidebar">
                        <Shimmer style="height: 20rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <div class="form-check" v-for="category in categories">
                            <input class="form-check-input" type="checkbox" name="category" :value="category.id" v-model="filterCategory">
                            <label class="form-check-label">
                                {{ category.name }} ({{ category.products.length }})
                            </label>
                        </div>
                    </div>

                    <h4 class='text-uppercase mt-4 mb-4'>Price</h4>
                    <div v-if="loadingSidebar">
                        <Shimmer style="height: 20rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
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
                    </div>

                    <h4 class='text-uppercase mb-4 mt-2'>Brands</h4>
                    <div v-if="loadingSidebar">
                        <Shimmer style="height: 20rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <div class="form-check" v-for="brand in brands">
                            <input class="form-check-input" type="checkbox" name="brand" :value="brand.id" v-model="filterBrand">
                            <label class="form-check-label">
                                {{ brand.name }} ({{ brand.product.length }})
                            </label>
                        </div>
                        <button @click="loadProduct" class="btn btn-primary btn-sm mt-4 w-100">
                            <i class="fas fa-filter me-2"></i>Apply Filter
                        </button>
                    </div>

                    <h4 class='text-uppercase mt-4 mb-4'>Top Selling</h4>
                    <div v-if="loadingSidebar">
                        <Shimmer style="height: 20rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <div class="d-block" v-for="product in topselling">
                            <div class="card border-0 mb-2">
                                <div class="card-body clearfix">
                                    <div class="float-start">
                                        <img :src="product.image" class='img img-responsive text-center' width="100"  alt="image" />
                                    </div>
                                    <div class="float-start">
                                        <div class="ms-4">
                                            <small class='text-primary d-block'>{{ product.category }}</small>  
                                            <small class="fw-bolder d-block">{{ product.name }}</small>
                                            <small class='text-danger me-2'>$ {{ product.price }}</small><del><small class='text-muted'>$ {{ product.price_old }}</small></del>
                                            <div class="clearfix text-warning">
                                                <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                                <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div v-if="loadingProduct">
                       <div class="row">
                            <div v-for="i in 12" class="col-md-4 col-xs-6 mb-2">
                                <Shimmer style="height: 20rem; border-radius: 5px;" />
                            </div>
                       </div>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                <label class="form-label fw-bold">Search</label>
                                <div class="input-group">
                                        <input type="text" v-model="search"  placeholder='Search here..' class="form-control" aria-label="Text input with dropdown button">
                                        <button  @click="loadProduct" class="btn btn-primary" type="button" >
                                            <span class="text-white"><i class="bi bi-search mb-1 me-1"></i>Search</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4 col-xs-6" v-for="product in products.list">
                                <div class="card mb-3">
                                    <img :src="product.image" class="card-img-top" alt="" />
                                    <div class="card-body p-4">
                                        <h6 class="fw-bolder">{{ product.name }}</h6>
                                        <strong class='text-danger me-2'>$ {{ product.price }}</strong><del><strong class='text-muted'>$ {{ product.price_old }}</strong></del>
                                        <div class="d-flex small text-warning">
                                            <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                            <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                                        </div>
                                        <span class='text-primary fw-bold mt-4'>
                                            <small>{{ product.category.join(", ") }}</small>
                                        </span>  
                                    </div>
                                    <div class="card-footer bg-transparent text-center border-top-0" v-if="auth_logged">
                                        <router-link :to="`/cart/${product.id}`" class="btn btn-primary text-white w-100 mb-2">
                                            <i class="bi bi-cart-plus mb-1 me-1"></i>Add To Cart
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-9">   
                                <Vue3BsPaginate
                                    :total="parseInt(products.total_filtered)"
                                    v-model="page"
                                    :perPage="parseInt(products.limit)"
                                    :onChange="loadProduct"
                                    alignment="left"
                                    ref="pagination"
                                />  
                            </div>
                            <div class="col-md-3 text-end">
                                <small class='text-muted mt-2'>Showing {{ products.limit }} - {{ products.total_filtered }} products</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>