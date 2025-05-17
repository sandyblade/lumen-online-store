<script setup>

    import { Form, Field } from 'vee-validate'
    import { ref } from 'vue'
    import * as yup from 'yup'
    import service from '../services'
    
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
            service.home.newsletter(values).then((result) => { 
                loading.value = false
                errorResponse.value = ''
                successResponse.value = result.data.message
                form.value.resetForm()
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

</script>

<template>
    <main class="flex-shrink-0 p-5  mt-auto" id="newsletter">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="newsletter text-center">
                        <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                        <div v-if="errorResponse" class="alert alert-danger">
                            <span>{{ errorResponse }}</span>
                        </div>
                        <div v-if="successResponse" class="alert alert-success">
                            <span>{{ successResponse }}</span>
                        </div>
                        <Form ref="form" :validation-schema="schema" @submit="submit" :initial-values="formData">
                            <div class="input-group newsletter-input-group">
                                <Field type="email" name="email" v-model="formData.email"  v-slot="{ field, errors }">
                                    <input v-bind="field" class="form-control" :class="errors.length > 0 ? 'is-invalid' : '' " :disabled="loading"   placeholder="Enter Your Email">
                                </Field>
                                <button type="submit" class="btn bg-primary btn-primary" :class="loading ? 'disabled': ''" id="button-addon2">
                                    <i :class="loading ? 'fas fa-circle-notch fa-spin mb-1 me-1' : 'bi bi-envelope mb-1 me-1'"></i>Subscribe
                                </button>
                            </div>
                        </Form>
                        <div class="clearfix mt-2">
                            <button  class="btn btn-light border me-1">
                                <i class="bi bi-facebook mb-1"></i>
                            </button>
                            <button class="btn btn-light border me-1">
                                <i class="bi bi-twitter mb-1"></i>
                            </button>
                            <button  class="btn btn-light border me-1">
                                <i class="bi bi-instagram mb-1"></i>
                            </button>
                            <button class="btn btn-light border">
                                <i class="bi bi-pinterest mb-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> 
</template>