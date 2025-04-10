<script setup>

defineProps({
    logged: Boolean,
})

</script>

<template>
    <nav class="navbar-light border navbar navbar-expand-lg navbar-light">
        <div class="container">
            <button aria-controls="basic-navbar-nav" type="button" aria-label="Toggle navigation" class="navbar-toggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="basic-navbar-nav">
                <div class="main-nav navbar-nav">
                    <router-link to="/" class="nav-link">Home</router-link>
                    <router-link to="/store" class="nav-link">Hot Deals</router-link>
                    <a class="nav-link" href="#">Categories</a>
                    <a class="nav-link" href="#">Laptops</a>
                    <a class="nav-link" href="#">Smartphones</a>
                    <a class="nav-link" href="#">Cameras</a>
                    <a class="nav-link" href="#">Accessories</a>
                </div>
            </div>
        </div>
    </nav>
</template>