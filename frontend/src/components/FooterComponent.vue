<script setup>
    
    defineProps({ 
        categories: Array,
        setting: {}
     })

    import { useRouter } from 'vue-router'
    
    const nowYear = new Date().getFullYear()
    const author = "Sandy Andryanto"
    const router = useRouter()

    function handleFilter(e, category_id){
        e.preventDefault();
        e.stopImmediatePropagation()
        const url = `store?category=${category_id}`
        setTimeout(() => { router.push(url) })
    }
    
</script>
<template>
    <footer id="footer" class="footer text-light">
       <div class="section bg-black">
            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>{{ setting.about_section }}</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="bi bi-pin-map me-2 text-white"></i>{{ setting.com_location }}</a></li>
                                <li><a href="#"><i class="bi bi-telephone-outbound me-2 text-white"></i>{{ setting.com_phone }}</a></li>
                                <li><a href="#"><i class="bi bi-envelope me-2 text-white"></i>{{ setting.com_email }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#" @click="(event) => handleFilter(event, 0)">Hot deals</a></li>
                                <li v-for="category in categories"><a class="dropdown-item" href="#"  @click="(event) => handleFilter(event, category.id)" >{{ category.name }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                            </div>
                        </div>
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       <div id="bottom-footer" class="section bg-dark p-5 text-center">
          <div class="container mt-3">
            <div class="row">
              <div class="col-md-12 text-class">
                <ul class="footer-payments">
                  <li><a href="#"><i class="fab fa-cc-visa me-2 text-white"></i></a></li>
                  <li><a href="#"><i class="bi bi-credit-card me-2 text-white"></i></a></li>
                  <li><a href="#"><i class="bi bi-paypal me-2 text-white"></i></a></li>
                  <li><a href="#"><i class="bi bi-master-card me-2 text-white"></i></a></li>
                  <li><a href="#"><i class="fab fa-cc-discover  me-2 text-white"></i></a></li>
                  <li><a href="#"><i class="fab fa-cc-amex me-2 text-white"></i></a></li>
                </ul>
                <span class="copyright">
                  Copyright {{ nowYear }} All rights reserved | This template is made with <i class="bi bi-heart mx-1 text-white"></i> by <a class='text-white' href="https://github.com/sandyblade" target="_blank">{{ author }}</a>
                </span>
              </div>
            </div>
          </div>
		</div>
    </footer>
</template>