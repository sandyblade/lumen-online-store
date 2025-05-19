<script setup>
    defineProps({ categories: Array })
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
                    <router-link to="/store" class="nav-link">Store</router-link>
                    <router-link :to="`/store?category=${category.id}`" class="nav-link" v-for="category in categories">
                        {{ category.name }}
                    </router-link>
                </div>
            </div>
        </div>
    </nav>
</template>