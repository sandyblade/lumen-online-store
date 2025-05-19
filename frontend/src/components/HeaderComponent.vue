<script setup>

    import { ref, onMounted, inject } from 'vue'
    import { Modal } from "bootstrap"
    import { useRouter } from 'vue-router'
    import services from '../services'

    const props = defineProps(['loadOrder', 'logged', 'categories', 'wishlist', 'cart', 'order'])
    const router = useRouter()
    const categorySelected = ref({})
    const auth_logged = localStorage.getItem('auth_token') !== null && localStorage.getItem('auth_user') !== null
    const auth_user = ref({})
    const search = defineModel('search')
    const swal = inject('$swal')
    
    let modalWishlist = ref(null)
    let modalCart = ref(null)
    let objWishlist = null
    let objCart = null

    onMounted(() => {

        objWishlist = new Modal(modalWishlist.value)
        objCart = new Modal(modalCart.value)

        if (localStorage.getItem('auth_user')) {
            let _auth_user = JSON.parse(localStorage.getItem('auth_user'))
            auth_user.value = {
                phone: _auth_user.phone ? _auth_user.phone : "Your Phone",
                first_name: _auth_user.first_name,
                last_name: _auth_user.last_name,
                city: _auth_user.city ? _auth_user.city : "Your City",
                country: _auth_user.country ? _auth_user.country : "Your Country",
            }
        }

    })

    function handleFilter(row){
        categorySelected.value = row
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

    function logout(e) {
        
        e.preventDefault();
        e.stopImmediatePropagation()

        if (localStorage.getItem('auth_token')) {
            localStorage.removeItem('auth_token')
        }

        if (localStorage.getItem('auth_user')) {
            localStorage.removeItem('auth_user')
        }

        router.push("/")
        setTimeout(() => { location.reload() })
    }

    function handleSearch(e){
        e.preventDefault();
        e.stopImmediatePropagation()
        if (search.value) {
            const keySearch = search.value
            const category = categorySelected.value
            const category_id = category.id ? category.id : 0
            const url =  category_id === 0 ? `store?search=${keySearch}` : `store?category=${category_id}&search=${keySearch}`
            setTimeout(() => { router.push(url) })
        }
    }

    function cancel(e){
        e.preventDefault();
        e.stopImmediatePropagation()
        swal.fire({
            title: "Are you sure ?",
            text: "Please confirm that you accept these terms.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, cancel it!",
            showLoaderOnConfirm: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                await services.order
                    .cancel()
                    .then((result) => {
                        const msg = result.data.message
                        objCart.hide();
                        swal.fire({
                            title: "Success!!",
                            text: msg,
                            icon: "success"
                        })
                        props.loadOrder()
                        router.push('/store')
                    })
            }
        })
    }
    

</script>

<template>
   <header>
        <div id="top-header" class='p-0 bg-dark'>
            <div class="container py-2">
                <div class='clearfix'>
                    <ul class="header-links float-start p-0">
                        <li v-if="auth_logged && auth_user !== null"><a href="https://wa.me/628989218470"><i class="bi bi-telephone-outbound me-1 mb-1 text-primary"></i>{{ auth_user.phone }}</a></li>
                        <li v-if="auth_logged && auth_user !== null"><a href="#"><i class="bi bi-envelope me-1 mb-1 text-primary"></i> {{ auth_user.first_name }} {{ auth_user.last_name }}</a></li>
                        <li v-if="auth_logged && auth_user !== null"><a href="#"><i class="bi bi-pin-map me-1 mb-1 text-primary"></i> {{ auth_user.city }}, {{ auth_user.country }}</a></li>
                    </ul>
                    <ul class="header-links float-end p-0 header-account">
                        <li v-if="auth_logged"><router-link to="/order" ><i class="bi bi-cart me-1 mb-1 text-primary"></i> List Order</router-link></li>
                        <li v-if="auth_logged"><router-link to="/account/profile" ><i class="bi bi-person-plus me-1 mb-1 text-primary"></i> My Account</router-link></li>
                        <li v-if="auth_logged"><router-link to="/account/password" ><i class="bi bi-lock me-1 mb-1 text-primary"></i> Change Password</router-link></li>
                        <li v-if="auth_logged">
                            <a href="#" @click="(event) => logout(event)"><i class="fas fa-sign-out me-1 mb-1 text-primary"></i> Sign Out </a>
                        </li>
                        <li v-if="!auth_logged"><router-link to="/auth/login"><i class="bi bi-person-circle me-1 mb-1 text-primary"></i> Login</router-link></li>
                        <li v-if="!auth_logged"><router-link to="/auth/register"><i class="bi bi-person-fill-add me-1 mb-1 text-primary"></i> Register</router-link></li>
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
                                    <span class="text-white"><i class="bi bi-cart me-1"></i>{{ Object.keys(categorySelected).length > 0 ? categorySelected.name : 'All Categories' }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" @click="handleFilter({})" >All Categories</a></li>
                                    <li v-for="category in categories"><a class="dropdown-item" href="#" @click="handleFilter(category)" >{{ category.name }}</a></li>
                                </ul>
                                <input type="text"  placeholder='Search here..' v-model="search" class="form-control" aria-label="Text input with dropdown button">
                                <button class="btn bg-dark" @click="(event) => handleSearch(event)"  type="button" >
                                    <span class="text-white"><i class="bi bi-search mb-1 me-1"></i>Search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 clearfix"> 
                       <div class="header-ctn" v-if="auth_logged">
                            <div class="position-relative" v-if="wishlist.length > 0">
                                <a href="#" @click="showModalWishlist" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-heart mb-2"></i>
                                    <span class='d-block'>Your Wishlist</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    {{ wishlist.length  }}
                                    <span class="visually-hidden">New Wishlist</span>
                                </span>
                            </div>
                            <div class="position-relative" v-if="cart.length > 0">
                                <a href="#" @click="showModalCart" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-cart mb-2"></i>
                                    <span class='d-block'>Your Cart</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    {{ cart.length  }}
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
                    <div class="row mb-2" v-for="product in wishlist">
                        <div class="col-md-4 text-center">
                            <img :src="product.image" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>{{ product.name }}</strong>
                            </a>
                            <h5>$ {{ parseInt(product.price) }}</h5>
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
                    <div class="row mb-2" v-for="product in cart">
                        <div class="col-md-4 text-center">
                            <img :src="product.image" class='img-thumbnail img-responsive' width="100" alt=""/>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="text-decoration-none text-uppercase text-muted d-block">
                                <strong>{{ product.name }}</strong>
                            </a>
                            <span class='d-block mb-2'>
                                {{ parseInt(product.total_item) }} x <strong>$ {{ parseInt(product.price) }}</strong>
                            </span>
                            <h5>$ {{ parseInt(product.subtotal) }}</h5>
                        </div>
                    </div>
                    <div class="cart-summary" v-if="order">
                        <small>{{ cart.length }} Item(s) selected</small>
                        <h5>SUBTOTAL: $ {{ parseInt(order.subtotal) }}</h5>
                    </div>
                    <div class="cart-btns" v-if="order">
                        <a href="#" @click="(event) => redirectTo(event, `/checkout/${order.id}`)" class="text-decoration-none">Checkout <i class="bi bi-arrow-right-circle ms-1"></i></a>
                        <a href="#" @click="(event) => cancel(event)"   class="text-decoration-none">Cancel Order <i class="bi bi-ban ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>