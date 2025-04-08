<script setup>

defineProps({
    logged: Boolean,
})

function handleFilter(event){
    console.log(event)
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
                        <li><a href="#"><i class="bi bi-person-plus me-1 mb-1 text-primary"></i> My Account</a></li>
                        <li><a href="#"><i class="bi bi-person-circle me-1 mb-1 text-primary"></i> Login</a></li>
                        <li><a href="#"><i class="bi bi-person-fill-add me-1 mb-1 text-primary"></i> Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="header" class="bg-primary p-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="#" class="logo">
                                <img src="/logo.png" alt="logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="header-search mt-3">
                            <div class="input-group">
                                <button class="btn bg-dark dropdown-toggle"type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-white">All Categories<i class="bi bi-filter ms-2"></i></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" @click="(event) => handleFilter(event)" >All Categories</a></li>
                                    <li><a class="dropdown-item" href="#" @click="(event) => handleFilter(event)">Laptop</a></li>
                                    <li><a class="dropdown-item" href="#" @click="(event) => handleFilter(event)">Accessories</a></li>
                                    <li><a class="dropdown-item" href="#" @click="(event) => handleFilter(event)">Camera</a></li>
                                    <li><a class="dropdown-item" href="#" @click="(event) => handleFilter(event)">Earphone</a></li>
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