<script setup>
    const nowYear = new Date().getFullYear()
</script>
<template>
    <main class="flex-shrink-0 p-3 border-bottom bg-gray text-uppercase mb-5" id="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-2">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Authentication</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-5">
       <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="card">
                        <div class="card-header text-center bg-primary p-2">
                            <h5 class="text-white"><i class="bi-person-lock me-2"></i>Forgot Password</h5>
                        </div>
                        <div class="card-body mb-2 p-4">
                            <div class="text-center">
                                 <img alt="logo" width="85" class="img img-responsive" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/app.png" />
                                  <p class="mt-2">
                                      <small>We'll e-mail you instructions on how to reset your password.</small>
                                  </p>
                            </div>
                            <form>
                                <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="bi-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" required />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary border w-100 mt-2" title="">
                                    <i class="bi-send me-2"></i>Request Password Reset
                                </button>
                            </form>
                            <div class="text-center mt-3">
                                <small>Already have an account ? <router-link to="/auth/login">Back To Sign In</router-link></small>
                            </div>
                        </div>
                        <div class="card-footer p-3 text-center bg-primary">
                            <span class="text-white">
                                <small>Copyright {{ nowYear }} - Elector Store</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </main>
</template>