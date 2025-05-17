<script setup>

    import {  ref } from 'vue'
    import { Form, Field } from 'vee-validate'
    import * as yup from 'yup'
    import { useRouter } from 'vue-router'
    import service from '../services'


    const nowYear = new Date().getFullYear()
    const router = useRouter()
    const loading = ref(false)
    const errorResponse = ref('')
    const successResponse = ref('')

    const schema = yup.object().shape({
        email: yup.string().email().required(),
    })

    const form = ref(null)
    
    const formData = ref({
        email: '',
    })

    const submit = (values) => {
        loading.value = true
        successResponse.value = ''
        errorResponse.value = ''
        setTimeout(() => { 
            service.auth.forgot(values).then((result) => { 
                
                loading.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
                form.value.resetForm()

                let token = result.data.token
                setTimeout(() => { 
                    router.push(`/auth/email/reset/${token}`)
                }, 2000)
               
            })
            .catch((error) => {
                loading.value = false
                errorResponse.value = error.response.data?.message
            });
        }, 1500)
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
                            <div v-if="errorResponse" class="alert alert-danger">
                                <span>{{ errorResponse }}</span>
                            </div>
                            <div v-if="successResponse" class="alert alert-success">
                                <span>{{ successResponse }}</span>
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
                                <button type="submit" class="btn btn-primary border w-100 mt-2" :class="loading ? 'disabled': ''" title="Click here to request">
                                    <i class="me-2" :class="loading ? 'fas fa-circle-notch fa-spin' : 'bi-send'"></i>Request Password Reset
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