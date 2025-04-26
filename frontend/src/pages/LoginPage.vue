<script setup>

    import {  ref } from 'vue'
    import { Form, Field } from 'vee-validate'
    import * as yup from 'yup'
    import service from '../services'

    const nowYear = new Date().getFullYear()
    const showPassword = ref(false)
    const loading = ref(false)
    const errorResponse = ref('')
       
    const schema = yup.object().shape({
        email: yup.string().email().required(),
        password: yup.string().required().min(6)
    })

    const formData = ref({
        email: '',
        password: '',
        remember: false
    })

    const form = ref(null)

    const submit = (values) => {
        values = {
            ...values,
            remember: formData.value.remember
        }
        loading.value = true
        errorResponse.value = ''
        setTimeout(() => { 
            service.auth.login(values).then(async (result) => { 

                loading.value = false
                errorResponse.value = ''
                form.value.resetForm()

                let token = result.data.token
                
                if (!localStorage.getItem('auth_token')) {
                    localStorage.setItem('auth_token', token)
                }

                let profile = await service.profile.detail()
                if (!localStorage.getItem('auth_user')) {
                    localStorage.setItem('auth_user', JSON.stringify(profile.data))
                }

                setTimeout(() => { 
                    location.reload()
                }, 1500)
                
            })
            .catch((error) => {
                loading.value = false
                errorResponse.value = error.response.data?.message
            });
        }, 1500)
    }
   
    function setShowPassword() {
        showPassword.value = !showPassword.value    
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
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
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
                            <h5 class="text-white"><i class="bi-person-lock me-2"></i>Login to your account</h5>
                        </div>
                        <div class="card-body mb-2 p-4">
                            <div class="text-center">
                                 <img alt="logo" width="85" class="img img-responsive" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/app.png" />
                                  <p class="mt-2">
                                      <small>Please sign in with your e-mail address and correct password.</small>
                                  </p>
                            </div>
                            <div v-if="errorResponse" class="alert alert-danger">
                                <span>{{ errorResponse }}</span>
                            </div>
                            <Form ref="form" :validation-schema="schema" @submit="submit" :initial-values="formData">
                                <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <Field type="email" name="email" v-model="formData.email"  v-slot="{ field, errors }">
                                            <span class="input-group-text">
                                                <i class="bi-envelope"></i>
                                            </span>
                                            <input v-bind="field" class="form-control" :class="errors.length > 0 ? 'is-invalid' : '' " :disabled="loading"   placeholder="Email Address">
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                         <Field  name="password" v-model="formData.password"  v-slot="{ field, errors }">
                                            <span class="input-group-text">
                                                <i class="bi-lock"></i>
                                            </span>
                                            <input v-bind="field" :type="showPassword ? 'text' : 'password'" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loading" placeholder="Credential Password">
                                            <span class="input-group-text input-group-password"  @click="setShowPassword()">
                                                <i :class="showPassword ? 'bi-eye' : 'bi-eye-slash'"></i>
                                            </span>
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                    </div>
                                </div>
                                <div class="clearfix mb-3">
                                    <div class="form-check float-start">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember" v-model="formData.remember"  :disabled="loading" /> Remember Me 
                                        </label>
                                    </div>
                                    <div class="float-end">
                                        <router-link to="/auth/email/forgot">
                                            <small class="fw-bold">Forgot Password ?</small>
                                        </router-link>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary border w-100 mt-2" :class="loading ? 'disabled': ''" title="Click here to sign in">
                                    <i class="me-2" :class="loading ? 'fas fa-circle-notch fa-spin' : 'bi-box-arrow-right'"></i>Sign In Now
                                </button>
                            </Form>
                            <div class="text-center mt-3">
                                <small>Don't have an account ? <router-link to="/auth/register">Sign Up Now</router-link></small>
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