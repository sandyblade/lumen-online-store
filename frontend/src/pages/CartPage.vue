<script setup>

    import 'vue3-carousel/carousel.css'
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import { ref, onMounted, inject } from 'vue'
    import StarRating from 'vue-star-rating'
    import Shimmer from "vue3-loading-shimmer"
    import services from "../services"
    import { useRoute, useRouter } from 'vue-router'
    import { Form, Field } from 'vee-validate'
    import * as yup from 'yup'

    const swal = inject('$swal')
    const props = defineProps(['loadOrder', 'setting'])

    const config = {
        itemsToShow: 1,
        gap: 5,
        wrapAround: true,
        autoplay: 4000,
        pauseAutoplayOnHover: true,
    }

    const configRelated = {
        itemsToShow: 3.5,
        gap: 5,
        wrapAround: true,
        autoplay: 3000,
        pauseAutoplayOnHover: true,
    }

    const rating = ref(0)
    const qty = ref(1)
    const price = ref(0)
    const priceOld = ref(0)
    const total = ref(0)
    const tabActive = ref(2)
    const loading = ref(true)
    const loadingReview = ref(true)
    const loadingSubmitReview = ref(false)
    const loadingSubmitProduct = ref(false)
    const loadingSubmitWhishlist = ref(false)
    const whishlist = ref(0)
    const reviews = ref([])
    const colours = ref([])
    const images = ref([])
    const product = ref({})
    const related = ref([])
    const sizes = ref([])
    const stocks = ref([])
    const route = useRoute()
    const router = useRouter()
    const selectSize = ref(0)
    const selectColour = ref(0)
    const errorResponse = ref('')
    const successResponse = ref('')
    const formReview = ref({})
    const user = ref({})

    const schemaReview = yup.object().shape({
        email: yup.string().email().required(),
        name: yup.string().required(),
        review: yup.string().required().min(5).max(200)
    })

    function setQty(type){
        if (type === '+') {
            qty.value = qty.value + 1
            total.value = price.value * qty.value
        } else {
            if (qty.value > 1) {
                qty.value = qty.value - 1
                total.value = price.value  * qty.value
            }
        }
    }
    
    function setTabActive(e, i) {
        e.preventDefault();
        e.stopImmediatePropagation();
        tabActive.value = i
    }

    function setCart(product_id) {
        router.push(`/cart/${product_id}`)
        loadData()
        loadReview()
    }

    function addWhishlist(id){
        whishlist.value = id
        errorResponse.value = ''
        successResponse.value = ''
        loadingSubmitWhishlist.value = true
        setTimeout(() => { 
            services.order.wishlist(id).then((result) => { 
                loadingSubmitWhishlist.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
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
                errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
                swal.fire({
                    title: "Failed !!",
                    text: errorResponse.value,
                    icon: "error"
                });
            });
        }, 1500)
    }

    async function loadData(){
        loading.value = true
        const id = route.params.id
        await services.order.cartDetail(id)
            .then((response) => {
                let data = response.data
                let productResponse = data.product
                product.value = productResponse
                colours.value = data.colours
                images.value = data.images
                related.value = data.related
                sizes.value = data.sizes
                stocks.value = data.stocks
                price.value = parseInt(productResponse.price)
                total.value = parseInt(productResponse.price)
                priceOld.value = data.price_old
                setTimeout(() => { 
                    loading.value = false
                }, 1500)
            })
            .catch((error) => {
                errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
            })
    }

    async function loadReview(){
        loadingReview.value = true
        const id = route.params.id
        const auth_user = JSON.parse(localStorage.getItem('auth_user'))
        await services.order.listReview(id)
            .then((response) => {
                let data = response.data
                reviews.value = data
                user.value = {
                    ...auth_user,
                    name: `${auth_user.first_name} ${auth_user.last_name}`
                }
                setTimeout(() => { 
                    loadingReview.value = false
                }, 1500)
            })
            .catch((error) => {
                console.log(error)
            })
    }

    const submitProduct = async () => {
        const values = {
            size_id: selectSize.value,
            color_id: selectColour.value,
            qty: qty.value
        }
        errorResponse.value = ''
        successResponse.value = ''
        loadingSubmitProduct.value = true
        setTimeout(() => { 
            const id = route.params.id
            services.order.cartAdd(id, values).then((result) => { 
                loadingSubmitProduct.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
                selectSize.value = 0
                selectColour.value = 0
                props.loadOrder()
                loadData()
            })
            .catch((error) => {
                console.log(error)
                loadingSubmitProduct.value = false
                errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
            });
        }, 1500)
    }

    const submitReview = (values) => { 
        values = {
            ...values,
            rating: rating.value
        }
        loadingSubmitReview.value = true
        errorResponse.value = ''
        successResponse.value = ''
        setTimeout(() => { 
            const id = route.params.id
            services.order.createReview(id, values).then((result) => { 
                loadingSubmitReview.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message 
                loadReview()
            })
            .catch((error) => {
                console.log(error)
                loadingSubmitReview.value = false
                errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
            });
        }, 1500)
    }

    onMounted(() => { 
        loadData()
        loadReview()
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
            <div v-if="errorResponse" class="alert alert-danger mb-4">
                <span>{{ errorResponse }}</span>
            </div>
            <div v-if="successResponse" class="alert alert-success mb-4">
                <span>{{ successResponse }}</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div v-if="loading">
                        <Shimmer style="height: 42rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <Carousel v-bind="config">
                            <Slide v-for="image in images" :key="image.id">
                                <img :src="image.path"  class='card-img-top' alt='' />
                            </Slide>
                            <template #addons>
                                <Navigation />
                                <Pagination />
                            </template>
                        </Carousel>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-if="loading">
                        <Shimmer class="mb-2" style="height: 14rem; border-radius: 5px;" />
                        <Shimmer class="mb-2" style="height: 14rem; border-radius: 5px;" />
                        <Shimmer style="height: 13rem; border-radius: 5px;" />
                    </div>
                    <div v-else>
                        <h3 class="fw-bolder text-uppercase">{{ product.name }}</h3>
                        <div class='clearfix mt-3 mb-1'>
                            <div class="small text-warning mb-2">
                                <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                            </div>
                            <a href='#' class='text-decoration-none'><small>{{ reviews.length }} Review(s) | Add your review</small></a>
                        </div>
                        <strong class='text-danger me-2'>${{ price }}</strong><del><strong class='text-muted'>$ {{ priceOld }}</strong></del><strong class='text-danger ms-2'>IN STOCK</strong>
                        <p class='mt-2'>
                           {{ product.description }}
                        </p>
                        <div class='clearfix mt-2'>
                            <button  class="btn btn-light border me-1" @click="addWhishlist(product.id)">
                                <i :class="loadingSubmitWhishlist && product.id === whishlist ? 'fas fa-circle-notch fa-spin me-1 disabled' : 'bi bi-heart me-1'"></i>
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
                            <a class='d-inline ms-1 text-decoration-none' v-for="category in product.categories" href="#">{{ category.name }} </a>
                        </div>
                        <div class='text-uppercase mt-2'>
                            <small class='text-muted d-inline'>Share :</small>
                            <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-facebook ms-1"></i></a>
                            <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-twitter ms-1"></i></a>
                            <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-google ms-1"></i></a>
                            <a class='d-inline ms-1 text-decoration-none' href="#"><i class="bi bi-instagram ms-1"></i></a>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Size <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="selectSize">
                                            <option value="0" disabled>Please Select Size</option>
                                            <option :value="row.id" v-for="row in sizes">{{ row.name }}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Colour <span class="text-danger">*</span></label>
                                        <select class="form-control" v-model="selectColour">
                                            <option value="0" disabled>Please Select Colour</option>
                                            <option :value="row.id" v-for="row in colours">{{ row.name }}</option>
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
                            <button @click="submitProduct" :class="!selectSize || !selectColour || loadingSubmitProduct ? 'disabled' : ''" class="btn btn-primary text-white w-100 mt-4">
                                <i  :class="loadingSubmitProduct ? 'fas fa-circle-notch fa-spin mb-1 me-1' : 'bi bi-cart-plus mb-1 me-1'"></i> Add To Cart
                            </button>
                        </div>
                    </div>
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
                            <a class="nav-link" @click="(event) => setTabActive(event, 2)" :class="tabActive === 2 ? 'active' : ''" href="#">Reviews ({{ reviews.length }})</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane container" :class="tabActive === 0 ? 'active p-0' : ''">
                            <div v-if="loading">
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                            </div>
                            <div v-else>
                                <p class='mt-3'>
                                    {{ product.description }}
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane container" :class="tabActive === 1 ? 'active p-0' : ''">
                           <div v-if="loading">
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                           </div>
                           <div v-else>
                                <p class='mt-3'>
                                    {{ product.details }}
                                </p>
                           </div>
                        </div>
                        <div class="tab-pane container" :class="tabActive === 2 ? 'active p-0' : ''">
                            <div class="row mt-3" v-if="loadingReview">
                                <Shimmer style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                                <Shimmer class="mt-2" style="height: 5rem; border-radius: 5px;" />
                            </div>
                            <div class="row mt-3" v-else>
                                <div class="col-md-3">
                                    <div class="clearfix">
                                        <h4 class='d-inline me-3'>{{ product.total_rating }}</h4>
                                        <div class="d-inline text-warning">
                                            <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                            <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                                        </div>
                                    </div>
                                    <div class="clearfix mt-2">
                                        <div class="row" v-for="r in reviews">
                                            <div class="col-md-6">
                                                <div class="d-inline text-warning">
                                                    <i class="bi bi-star-fill" v-for="index in r.rating_index" :key="index"></i>
                                                    <i class="bi bi-star" v-if="r.rating_index < 5" v-for="idx in (5 - r.rating_index)" :key="idx"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               <div class="progress">
                                                    <div class="progress-bar bg-warning" :style="`width:${r.rating}%`">{{ r.rating }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" v-for="r in reviews">
                                        <div class="col-md-4">
                                            <strong class='d-block'>{{ r.user.first_name }} {{ r.user.last_name }}</strong>
                                            <small class='small'>{{ r.created_at }}</small>
                                            <div class="text-warning">
                                                <i class="bi bi-star-fill" v-for="index in r.rating_index" :key="index"></i>
                                                <i class="bi bi-star" v-if="r.rating_index < 5" v-for="idx in (5 - r.rating_index)" :key="idx"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <p>{{ r.review }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <Form ref="formReview" :validation-schema="schemaReview" @submit="submitReview" :initial-values="formReview">
                                        <Field  name="name" v-model="user.name"  v-slot="{ field, errors }">
                                            <input v-bind="field" type="text" class="form-control mb-2" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmitReview" placeholder="Your Name">
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                        <Field name="email" v-model="user.email"  v-slot="{ field, errors }">
                                            <input v-bind="field" type="email" class="form-control mb-2" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmitReview" placeholder="Your E-Mail Address">
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                        <Field  name="review"  v-slot="{ field, errors }">
                                            <textarea rows="3" v-bind="field"  placeholder='Your Review' class="form-control mb-2" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmitReview" ></textarea>
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                        <StarRating v-model:rating="rating" :star-size="20" :show-rating="false" />
                                        <button :class="rating === 0 || loadingSubmitReview ? 'disabled' : ''" class="btn btn-primary text-white w-100 mt-3">
                                            <i :class="loadingSubmitReview ? 'fas fa-circle-notch fa-spin mb-1 me-1' : 'bi bi-telegram mb-1 me-1'"></i> Submit
                                        </button>
                                    </Form>
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
                    <div v-if="loading">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <Shimmer style="height: 25rem; border-radius: 5px;" />
                            </div>
                            <div class="col-md-4">
                                <Shimmer style="height: 25rem; border-radius: 5px;" />
                            </div>
                            <div class="col-md-4">
                                <Shimmer style="height: 25rem; border-radius: 5px;" />
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="slider-container text-center">
                            <Carousel v-bind="configRelated">
                                <Slide v-for="product in related" :key="product.id">
                                    <div class="card me-2">
                                        <template v-if="product.newest">
                                            <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-30%</div>
                                            <div class="badge bg-danger text-white position-absolute product-label rounded-0" style="right:3.5rem" >NEW</div>
                                        </template>
                                        <template v-if="product.discount">
                                            <div class="badge bg-success text-white position-absolute product-label rounded-0" style="right:0.5rem" >-50%</div>
                                        </template>
                                        <img :src="product.image" alt="image" />
                                        <div class="card-body p-4">
                                            <h5 class='text-primary'>{{ product.category }}</h5>  
                                            <h6 class="fw-bolder">{{ product.name }}</h6>
                                            <strong class='text-danger me-2'>$ {{ product.price }}</strong><del><strong class='text-muted'>$ {{ product.price_old }}</strong></del>
                                            <div class="d-flex justify-content-center small text-warning">
                                                <i class="bi bi-star-fill" v-for="index in product.total_rating" :key="index"></i>
                                                <i class="bi bi-star" v-if="product.total_rating < 5" v-for="idx in (5 - product.total_rating)" :key="idx"></i>
                                            </div>
                                            <div class="clearfix text-center mt-2">
                                                <button class="btn btn-light border me-1" @click="addWhishlist(product.id)">
                                                    <i :class="loadingSubmitWhishlist && product.id === whishlist ? 'fas fa-circle-notch fa-spin me-1 disabled' : 'bi bi-heart me-1'"></i>
                                                </button>
                                                <button class="btn btn-light border me-1">
                                                    <i class="bi bi-currency-exchange"></i>
                                                </button>
                                                <button class="btn btn-light border me-1">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            <button @click="setCart(product.id)" class="btn btn-primary w-100 mt-4">
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
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>