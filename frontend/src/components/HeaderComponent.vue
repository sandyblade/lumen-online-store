<script setup>

    import { ref } from 'vue'

    defineProps({
        logged: Boolean,
    })

    const fliterSelected = ref(0)
    const filters = ["All Categories", "Laptop", "Accessories", "Camera", "Earphone"]

    function handleFilter(index){
        fliterSelected.value = index
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
                                <a href="#" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-heart mb-2"></i>
                                    <span class='d-block'>Your Wishlist</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    2
                                    <span class="visually-hidden">New Wishlist</span>
                                </span>
                            </div>
                            <div class="position-relative">
                                <a href="#" class="text-center text-decoration-none fw-bold">
                                    <i class="bi bi-cart mb-2"></i>
                                    <span class='d-block'>Your Cart</span>
                                </a>
                                <span class="position-absolute top-0 ms-3 start-50 translate-middle badge rounded-pill bg-danger">
                                    2
                                    <span class="visually-hidden">New Wishlist</span>
                                </span>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
   </header>
</template>