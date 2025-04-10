<script setup>

    import { ref } from 'vue'

    const payment = ref(null)
    const accept  = ref(false)
    
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
                            <li class="breadcrumb-item active" aria-current="page">Check Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-5">
       <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <form>
                        <h3 class='text-uppercase mb-3 text-center'>Billing address</h3>
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your First Name" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Last Name" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Mail Address <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your E-Mail Address" type="email" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Phone Number" type="tel" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your City" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Country" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input placeholder="Enter Your Zip Code" type="text" class="form-control" value="">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="text-danger">*</span></label>
                            <textarea rows="3" placeholder='Enter Your Street Address' class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes </label>
                            <textarea rows="3" placeholder='Enter Your Notes' class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                 <div class="col-md-7">
                    <h3 class='text-uppercase mb-3 text-center'>Details Order</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-3 text-center">
                                    <img class="img-responsive" width="120" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product01.png"  alt="image" />
                                </div>
                                <div class="col-md-7 text-start p-3">
                                    <a href='#' class='text-decoration-none text-uppercase text-muted d-block mt-3'>
                                        <strong>product name goes here</strong>
                                    </a>
                                    <span class='d-block mb-2 text-danger fw-bold'>
                                        1 x <strong>$980.00</strong>
                                    </span>
                                </div>
                                <div class="col-md-2 text-end p-3">
                                    <h6 class='text-danger fw-bold mt-4'>$980.00</h6>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 text-center">
                                    <img class="img-responsive" width="120" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product02.png"  alt="image" />
                                </div>
                                <div class="col-md-7 text-start p-3">
                                    <a href='#' class='text-decoration-none text-uppercase text-muted d-block mt-3'>
                                        <strong>product name goes here</strong>
                                    </a>
                                    <span class='d-block mb-2 text-danger fw-bold'>
                                        2 x <strong>$980.00</strong>
                                    </span>
                                </div>
                                <div class="col-md-2 text-end p-3">
                                    <h6 class='text-danger fw-bold mt-4'>$1960.00</h6>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 text-center">
                                    <img class="img-responsive" width="120" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/product03.png"  alt="image" />
                                </div>
                                <div class="col-md-7 text-start p-3">
                                    <a href='#' class='text-decoration-none text-uppercase text-muted d-block mt-3'>
                                        <strong>product name goes here</strong>
                                    </a>
                                    <span class='d-block mb-2 text-danger fw-bold'>
                                        3 x <strong>$980.00</strong>
                                    </span>
                                </div>
                                <div class="col-md-2 text-end p-3">
                                    <h6 class='text-danger fw-bold mt-4'>$2940.00</h6>
                                </div>
                            </div>
                            <div class='border-top'></div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>subtotal</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$5,880.00</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>Shiping</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$100.00</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>Taxes (5%)</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$294.00</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h3 class='text-start text-muted fw-bold text-uppercase'>Total</h3>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$6274.00</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-12">
                                    <form>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment" v-model="payment" :value="1">
                                            <label class="form-check-label">
                                                Direct Bank Transfer
                                            </label>
                                        </div>
                                        <p class="d-block p-1" v-if="payment === 1">
                                            <small>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </small>
                                        </p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment" v-model="payment" :value="2">
                                            <label class="form-check-label">
                                                Cheque Payment
                                            </label>
                                        </div>
                                         <p class="d-block p-1" v-if="payment === 2">
                                            <small>
                                                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, 
                                                making it over 2000 years old. Richard McClintoc, There are many variations of passages of Lorem Ipsum available, 
                                                but the majority have suffered alteration in some form
                                            </small>
                                        </p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment" v-model="payment" :value="3">
                                            <label class="form-check-label">
                                                Paypal System
                                            </label>
                                        </div>
                                        <p class="d-block p-1" v-if="payment === 3"> 
                                            <small>
                                               It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing 
                                               software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </small>
                                        </p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" v-model="accept"  value="">
                                            <label class="form-check-label">
                                                I've read and accept the terms & conditions
                                            </label>
                                        </div>
                                        <button class="btn btn-primary btn-lg w-100 mt-4" :class="!accept ? 'disabled' : ''">
                                            <i class="bi bi-cart-check mb-1 me-1"></i> Place order
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </main>
</template>