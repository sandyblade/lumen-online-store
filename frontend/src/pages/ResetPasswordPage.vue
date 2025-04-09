<script setup>

    import { ref } from 'vue'

    const nowYear = new Date().getFullYear()
    const showPassword = ref(false)
    const showPasswordConfirm = ref(false)

    function setShowPassword() {
        showPassword.value = !showPassword.value    
    }

    function setShowPasswordConfirm() {
        showPasswordConfirm.value = !showPasswordConfirm.value    
    }
    
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
                            <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
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
                            <h5 class="text-white"><i class="bi-person-plus me-2"></i>Reset Password Account</h5>
                        </div>
                        <div class="card-body mb-2 p-4">
                            <div class="text-center">
                                 <img alt="logo" width="85" class="img img-responsive" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/app.png" />
                                  <p class="mt-2">
                                       <small>Enter a new password to reset the password on your account. We'll ask for this password whenever you log in.</small>
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
                                <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="bi-lock"></i>
                                        </span>
                                        <input :type="showPassword ? 'text' : 'password'"  name="password" class="form-control" placeholder="Account Password" required />
                                        <span class="input-group-text input-group-password"  @click="setShowPassword()">
                                            <i :class="showPassword ? 'bi-eye' : 'bi-eye-slash'"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="bi-lock"></i>
                                        </span>
                                        <input :type="showPasswordConfirm ? 'text' : 'password'"  name="password" class="form-control" placeholder="Confirm Account Password" required />
                                        <span class="input-group-text input-group-password"  @click="setShowPasswordConfirm()">
                                            <i :class="showPasswordConfirm ? 'bi-eye' : 'bi-eye-slash'"></i>
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary border w-100 mt-2" title="Click here to sign in">
                                    <i class="bi-box-arrow-right me-2"></i>Reset Password
                                </button>
                            </form>
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