<script setup>

    import { ref, onMounted } from 'vue'
    import { Modal } from "bootstrap"
    import { useRouter } from 'vue-router'

    defineProps({
        logged: Boolean,
    })

    const router = useRouter()
    const fliterSelected = ref(0)
    const filters = ["All Categories", "Laptop", "Accessories", "Camera", "Earphone"]

    let modalWishlist = ref(null)
    let modalCart = ref(null)
    let objWishlist = null
    let objCart = null

    onMounted(() => {
        objWishlist = new Modal(modalWishlist.value)
        objCart = new Modal(modalCart.value)
    })

    function handleFilter(index){
        fliterSelected.value = index
    }

    function showModalWishlist(){
        objWishlist.show();
    }

    function showModalCart(){
        objCart.show();
    }
    
    function redirectTo(e, url) {
        e.preventDefault();
        e.stopImmediatePropagation()
        objCart.hide();
        setTimeout(() => { router.push(url) })
    }
    

</script>

<template>
   <header>
        <div id="top-header" class='p-0 bg-dark'>
            <div class="container py-2">
                <div class='clearfix'>
                    <ul class="header-links float-start p-0">
                        <li><a href="https://wa.me/628989218470"><i class="bi bi-telephone-outbound me-1 mb-1 text-primary"></i> +62-898-921-8470</a></li>
                        <li><a href="#"><i class="bi bi-envelope me-1 mb-1 text-primary"></i> sandy.andryanto.blade@gmail.com</a></li>
                        <li><a href="#"><i class="bi bi-pin-map me-1 mb-1 text-primary"></i> West Java, Indonesia</a></li>
                    </ul>
                    <ul class="header-links float-end p-0 header-account">
                        <li><a href="#"><i class="bi bi-currency-dollar me-1 mb-1 text-primary"></i> USD</a></li>
                        <li><router-link to="/account/profile" ><i class="bi bi-person-plus me-1 mb-1 text-primary"></i> My Account</router-link></li>
                        <li><router-link to="/auth/login"><i class="bi bi-person-circle me-1 mb-1 text-primary"></i> Login</router-link></li>
                        <li><router-link to="/auth/register"><i class="bi bi-person-fill-add me-1 mb-1 text-primary"></i> Register</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="header" class="bg-primary p-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="header-logo">
                            <router-link to="/" class="logo">
                                <img src="/logo.png" alt="logo" />
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="header-search mt-3">
                            <div class="input-group">
                                <button class="btn bg-dark dropdown-toggle"type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-white"><i class="bi bi-cart me-1"></i>{{ filters[fliterSelected] }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li v-for="(filter, index) in filters"><a class="dropdown-item" href="#" @click="handleFilter(index)" >{{ filter }}</a></li>
                                </ul>
                                <input type="text"  placeholder='Search here..' class="form-control" aria-label="Text input with dropdown button">
                                <button class="btn bg-dark" type="button" >
                                    <span class="text-white"><i class="bi bi-search mb-1 me-1"></i>Search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 clearfix"> 
                       <div class="header-ctn">
                            <div class="position-relative">
                                <a href="#" @click="showModalWishlist" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-heart mb-2"></i>
                                    <span class='d-block'>Your Wishlist</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    2
                                    <span class="visually-hidden">New Wishlist</span>
                                </span>
                            </div>
                            <div class="position-relative">
                                <a href="#" @click="showModalCart" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-cart mb-2"></i>
                                    <span class='d-block'>Your Cart</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    3
                                    <span class="visually-hidden">Your Cart</span>
                                </span>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
   </header>

   <div class="modal fade" tabindex="-1" ref="modalWishlist">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <i class="bi bi-heart me-1"></i>My Wishlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4 text-center">
                            <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>product name goes here</strong>
                            </a>
                            <h5>$980.00</h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 text-center">
                            <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>product name goes here</strong>
                            </a>
                            <h5>$1960.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" ref="modalCart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <i class="bi bi-cart me-1"></i>My Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4 text-center">
                            <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>product name goes here</strong>
                            </a>
                            <span class='d-block mb-2'>
                                1 x <strong>$980.00</strong>
                            </span>
                            <h5>$980.00</h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 text-center">
                            <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>product name goes here</strong>
                            </a>
                            <span class='d-block mb-2'>
                                2 x <strong>$980.00</strong>
                            </span>
                            <h5>$1960.00</h5>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 text-center">
                            <img src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>product name goes here</strong>
                            </a>
                            <span class='d-block mb-2'>
                                3 x <strong>$980.00</strong>
                            </span>
                            <h5>$2940.00</h5>
                        </div>
                    </div>
                    <div class="cart-summary">
                        <small>3 Item(s) selected</small>
                        <h5>SUBTOTAL: $5880.00</h5>
                    </div>
                    <div class="cart-btns">
                        <a href="#" @click="(event) => redirectTo(event, '/cart')"   class="text-decoration-none">View Cart <i class="bi bi-cart ms-1"></i></a>
                        <a href="#" @click="(event) => redirectTo(event, '/checkout')" class="text-decoration-none">Checkout <i class="bi bi-arrow-right-circle ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>