<script setup>

    import { ref, onMounted, inject } from 'vue'
    import { Form, Field } from 'vee-validate'  
    import * as yup from 'yup'
    import Shimmer from "vue3-loading-shimmer"
    import services from '../services'
    import { useRouter, useRoute } from 'vue-router'

    const payment = ref(null)
    const accept  = ref(false)
    const loadingContent = ref(true)
    const loadingSubmit = ref(false)
    const props = defineProps(['loadOrder', 'setting'])
    const billing = ref({})
    const payments = ref([])
    const cart = ref([])
    const order = ref({})
    const errorResponse = ref('')
    const form = ref()
    const swal = inject('$swal')
    const router = useRouter()
    const route = useRoute()
    
    const schema = yup.object().shape({
        email: yup.string().email().required(),
        first_name: yup.string().required(),
        last_name: yup.string().required(),
        gender: yup.string().required(),
        phone: yup.string().required(),
        city: yup.string().required(),
        country: yup.string().required(),
        zip_code: yup.string().required(),
        address: yup.string().required(),
    })


    async function loadData(){
        let id = route.params.id
        loadingContent.value = true
        errorResponse.value = ''
        await services.order.billing(id).then((reponse) => { 
            const data = reponse.data
            billing.value = data.billing
            payments.value = data.payments
            cart.value = data.cart
            order.value = data.order
            payment.value = data.payments[1].id
            setTimeout(() => { 
                loadingContent.value = false
            }, 1500)
        })
        .catch((error) => {
            errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
        });
    }


    const submit = (values) => { 
        const id = order.value.id
        values = {
            ...values,
            payment_id: payment.value
        }
        swal.fire({
            title: "Are you sure ?",
            text: "Please confirm that you accept these terms.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, checkout it!",
            showLoaderOnConfirm: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                loadingSubmit.value = true
                await services.order
                    .checkout(id, values)
                    .then((result) => {
                        loadingSubmit.value = false
                        const msg = result.data.message
                        swal.fire({
                            title: "Success!!",
                            text: msg,
                            icon: "success"
                        })
                        props.loadOrder()
                        router.push('/order')
                    })
            }
        })
    }

    onMounted(() => {
        loadData()
    })
    
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
            <div v-if="errorResponse" class="alert alert-danger mb-4">
                <span>{{ errorResponse }}</span>
            </div>
            <div class="row">
                <div class="col-md-5" v-if="loadingContent">
                    <h3 class='text-uppercase mb-3 text-center'>Billing address</h3>
                    <Shimmer style="height: 50rem; border-radius: 10px;" />
                </div>
                <div class="col-md-5" v-else>
                    <Form ref="form" :validation-schema="schema" @submit="submit" :initial-values="billing">
                        <h3 class='text-uppercase mb-3 text-center'>Billing address</h3>
                        <div class="mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <Field  name="first_name" v-model="billing.first_name"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your First Name">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <Field  name="last_name" v-model="billing.last_name"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Last Name">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">E-Mail Address <span class="text-danger">*</span></label>
                            <Field name="email" v-model="billing.email"  v-slot="{ field, errors }">
                                <input v-bind="field" type="email" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your E-Mail Address">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <Field  name="phone" v-model="billing.phone"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Phone Number">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <Field  name="city" v-model="billing.city"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your City">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <Field  name="country" v-model="billing.country"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Country">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <Field  name="zip_code" v-model="billing.zip_code"  v-slot="{ field, errors }">
                                <input v-bind="field" type="text" class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" placeholder="Enter Your Zip Code">
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Street Address <span class="text-danger">*</span></label>
                            <Field  name="address" v-model="billing.address"  v-slot="{ field, errors }">
                                <textarea rows="3" v-bind="field"  placeholder='Enter Your Street Address' class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" ></textarea>
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes </label>
                            <Field  name="notes" v-model="billing.notes"  v-slot="{ field, errors }">
                                <textarea rows="3" v-bind="field"  placeholder='Enter Your Notes' class="form-control" :class="errors.length > 0 ? 'is-invalid' : ''" :disabled="loadingSubmit" ></textarea>
                                <div :class="errors.length > 0 ? 'invalid-feedback' : ''">
                                    <span class="d-block" v-for="item in errors">
                                        {{ item }}
                                    </span>
                                </div>
                            </Field>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" :class="!accept || loadingSubmit ? 'disabled' : ''">
                            <i :class="loadingSubmit ? 'fas fa-circle-notch fa-spin mb-1 me-1' : 'bi bi-cart-check mb-1 me-1'"></i> Place order
                        </button>
                    </Form>
                </div>
                <div class="col-md-7" v-if="loadingContent">
                    <h3 class='text-uppercase mb-3 text-center'>Details Order</h3>
                    <Shimmer style="height: 50rem; border-radius: 10px;" />
                </div>
                <div class="col-md-7" v-else>
                    <h3 class='text-uppercase mb-3 text-center'>Details Order</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2" v-for="product in cart">
                                <div class="col-md-3 text-center">
                                    <img class="img-responsive" width="120" :src="product.image"  alt="image" />
                                </div>
                                <div class="col-md-7 text-start p-3">
                                    <a href='#' class='text-decoration-none text-uppercase text-muted d-block mt-3'>
                                        <strong>{{ product.name }}</strong>
                                    </a>
                                    <span class='d-block mb-2 text-danger fw-bold'>
                                        {{ parseInt(product.total_item) }} x <strong>$ {{ parseFloat(product.price).toFixed(2) }}</strong>
                                    </span>
                                </div>
                                <div class="col-md-2 text-end p-3">
                                    <h6 class='text-danger fw-bold mt-4'>$ {{ parseFloat(product.subtotal).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class='border-top'></div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>subtotal</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$ {{ parseFloat(order.subtotal).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>Shiping</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$ {{ parseFloat(order.total_shipment).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>Taxes ( {{ parseFloat(setting.taxes_value).toFixed(2) }} %)</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$ {{ parseFloat(order.total_taxes).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h6 class='text-start text-muted fw-bold text-uppercase'>Discount ( {{ parseFloat(setting.discount_value).toFixed(2) }} %)</h6>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-success fw-bold'>$ {{ parseFloat(order.total_discount).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-3">
                                    <h3 class='text-start text-muted fw-bold text-uppercase'>Total</h3>
                                </div>
                                <div class="col-md-9 text-end">
                                    <h6 class='text-danger fw-bold'>$ {{ parseFloat(order.total_paid).toFixed(2) }}</h6>
                                </div>
                            </div>
                            <div class="row mb-1 p-2 mt-2">
                                <div class="col-md-12">
                                    <div v-for="p in payments">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment" v-model="payment" :value="p.id">
                                            <label class="form-check-label">
                                                {{ p.name }}
                                            </label>
                                        </div>
                                        <p class="d-block p-1" v-if="payment === p.id">
                                            <small>
                                                {{ p.description }}
                                            </small>
                                        </p>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="accept"  value="">
                                        <label class="form-check-label">
                                            I've read and accept the terms & conditions
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </main>
</template>