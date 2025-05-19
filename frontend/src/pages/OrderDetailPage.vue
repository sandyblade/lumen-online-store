<script setup>

    import { ref, onMounted, inject } from 'vue'
    import { useRouter, useRoute } from 'vue-router'
    import Shimmer from "vue3-loading-shimmer"
    import services from '../services'

    const props = defineProps(['loadOrder', 'setting'])
    const billing = ref({})
    const cart = ref([])
    const order = ref({})
    const errorResponse = ref('')
    const swal = inject('$swal')
    const router = useRouter()
    const loading = ref(true)
    const route = useRoute()

    async function loadData(){
        let id = route.params.id
        loading.value = true
        errorResponse.value = ''
        await services.order.billing(id).then((reponse) => { 
            const data = reponse.data
            billing.value = data.billing
            cart.value = data.cart
            order.value = data.order
            setTimeout(() => { 
                loading.value = false
            }, 1500)
        })
        .catch((error) => {
            errorResponse.value = error.status === 401 ? services.expiredMessage : (error.response.data?.message || error.message)
        });
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
                            <li class="breadcrumb-item"><router-link to="/order">Order</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-4">
        <div class="container">
            <div v-if="errorResponse" class="alert alert-danger mb-4">
                <span>{{ errorResponse }}</span>
            </div>
            <div class="row">
                <div class="col-md-5" v-if="loading">
                    <h3 class='text-uppercase mb-3 text-center'>Details Invoice</h3>
                    <Shimmer style="height: 50rem; border-radius: 10px;" />
                </div>
                <div class="col-md-5" v-else>
                    <h3 class='text-uppercase mb-3 text-center'>Details Invoice</h3>
                    <table class="table mt-2 mb-4 border">
                        <tbody>
                            <tr>
                                <td>Invoice Number</td>
                                <td>:</td>
                                <td width="350">{{ order.invoice_number }}</td>
                            </tr>
                            <tr>
                                <td>Invoice Date</td>
                                <td>:</td>
                                <td>{{ order.created_at }}</td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td>:</td>
                                <td>{{ order.payment?.name }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <span v-if="order.status === 1">
                                        <span class="badge bg-success">Completed</span>
                                    </span>
                                    <span v-else>
                                        <span class="badge bg-danger">Draft</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h3 class='text-uppercase mb-3 text-center'>Billing address</h3>
                    <table class="table mt-2 border">
                       <tbody>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td width="350">{{ billing.first_name }}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td>{{ billing.last_name }}</td>
                            </tr>
                            <tr>
                                <td>E-Mail Address</td>
                                <td>:</td>
                                <td>{{ billing.email }}</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>:</td>
                                <td>{{ billing.phone }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>:</td>
                                <td>{{ billing.city }}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                <td>{{ billing.country }}</td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>:</td>
                                <td>{{ billing.zip_code }}</td>
                            </tr>
                            <tr>
                                <td>Street Address</td>
                                <td>:</td>
                                <td>{{ billing.address }}</td>
                            </tr>
                            <tr>
                                <td>Notes</td>
                                <td>:</td>
                                <td>{{ billing.notes }}</td>
                            </tr>
                       </tbody>
                    </table>
                </div>
                <div class="col-md-7" v-if="loading">
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
                        </div>
                    </div>
                    <router-link to="/order" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-left me-2"></i>Back To List Order
                    </router-link>
                </div>
            </div>
        </div>
    </main>
</template>