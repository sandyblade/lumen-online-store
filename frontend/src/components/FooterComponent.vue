<script setup>
    const nowYear = new Date().getFullYear()
    const author = "Sandy Andryanto"
</script>
<template>
    <footer id="footer" class="footer text-light">
       <div class="section bg-black">
            <div class="container mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="bi bi-pin-map me-2 text-white"></i>West Java, Indonesia</a></li>
                                <li><a href="https://wa.me/628989218470"><i class="bi bi-telephone-outbound me-2 text-white"></i>+62-898-921-8470</a></li>
                                <li><a href="#"><i class="bi bi-envelope me-2 text-white"></i>sandy.andryanto.blade@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
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