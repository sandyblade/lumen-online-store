<script setup>

    import {  ref } from 'vue'
    import { Form, Field } from 'vee-validate'
    import * as yup from 'yup'
    import { useRouter } from 'vue-router'
    import service from '../services'

    const router = useRouter()
    const nowYear = new Date().getFullYear()
    const showPassword = ref(false)
    const showPasswordConfirm = ref(false)
    const loading = ref(false)
    const errorResponse = ref('')
    const successResponse = ref('')

    const schema = yup.object().shape({
        name: yup.string().required('Person name is a required').min(3),
        email: yup.string().email().required(),
        password: yup.string().required().min(6),
        password_confirmation: yup.string().required('Password confirm is a required').oneOf([yup.ref('password'), null], 'Passwords must match'),
    })

    const form = ref(null)
    
    const formData = ref({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    })

    const submit = (values) => { 
        
        loading.value = true
        errorResponse.value = ''
        successResponse.value = ''

        setTimeout(() => { 
            service.auth.register(values).then((result) => { 
                
                loading.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
                form.value.resetForm()

                let token = result.data.token
                setTimeout(() => { 
                    router.push(`/auth/register/confirm/${token}`)
                }, 2000)
            })
            .catch((error) => {
                loading.value = false
                if (error.response.data) {
                    let results = error.response.data
                    if (('email' in results)) {
                        if (results['email'][0]) {
                            errorResponse.value = results['email'][0]
                        }
                    }
                }
            });
        }, 1500)

    }

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
                            <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                            <h5 class="text-white"><i class="bi-person-plus me-2"></i>Sign Up New Account</h5>
                        </div>
                        <div class="card-body mb-2 p-4">
                            <div class="text-center">
                                 <img alt="logo" width="85" class="img img-responsive" src="https://5an9y4lf0n50.github.io/demo-images/demo-commerce/app.png" />
                                  <p class="mt-2">
                                       <small>Please fill in form to create new account.</small>
                                  </p>
                            </div>
                            <div v-if="errorResponse" class="alert alert-danger">
                                <span>{{ errorResponse }}</span>
                            </div>
                            <div v-if="successResponse" class="alert alert-success">
                                <span>{{ successResponse }}</span>
                            </div>
                            <Form ref="form" :validation-schema="schema" @submit="submit" :initial-values="formData">
                                <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <Field type="text" name="name" v-model="formData.name"  v-slot="{ field, errors }">
                                            <span class="input-group-text">
                                                <i class="bi-person-circle"></i>
                                            </span>
                                            <input v-bind="field" class="form-control" :class="errors.length > 0 ? 'is-invalid' : '' " :disabled="loading"   placeholder="Full Name">
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
                                            <input v-bind="field" :type="showPassword ? 'text' : 'password'" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loading" placeholder="Account Password">
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
                                 <div class="mb-3 mt-2">
                                    <div class="input-group mb-3">
                                        <Field  name="password_confirmation" v-model="formData.password_confirmation"  v-slot="{ field, errors }">
                                            <span class="input-group-text">
                                                <i class="bi-lock"></i>
                                            </span>
                                            <input v-bind="field" :type="showPasswordConfirm ? 'text' : 'password'" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loading" placeholder="Confirm Account Password">
                                            <span class="input-group-text input-group-password"  @click="setShowPasswordConfirm()">
                                                <i :class="showPasswordConfirm ? 'bi-eye' : 'bi-eye-slash'"></i>
                                            </span>
                                            <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                                <span class="d-block" v-for="item in errors">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </Field>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary border w-100 mt-2" :class="loading ? 'disabled': ''" title="Click here to sign up">
                                    <i class="me-2" :class="loading ? 'fas fa-circle-notch fa-spin' : 'bi-box-arrow-right'"></i>Sign Up Now
                                </button>
                            </Form>
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