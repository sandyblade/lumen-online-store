<script setup>

    import { Vue3BsPaginate } from 'vue3-bootstrap-paginate';
    import queryString from 'query-string'
    import { useRouter } from 'vue-router'
    import { ref, onMounted, inject } from 'vue'
    import services from '../services';

    const loading = ref(true)
    const limit = ref(10)
    const sort = ref('id')
    const dir = ref('desc')
    const search = ref('')
    const page = ref(1)
    const total_all = ref(0)
    const total_fitered = ref(0)
    const router = useRouter()
    const pagination = ref(null)
    const rows = ref([])
    const swal = inject('$swal')
    const props = defineProps(['loadOrder', 'setting'])

    function loadData(){

        let params = {
            dir: dir.value,
            sort: sort.value,
            limit: limit.value,
            page: parseInt(page.value)
        }

        if (search.value) {
            params = {
                ...params,
                search: search.value
            }
        }

        loading.value = true
        const filterQueryParam = decodeURIComponent(queryString.stringify(params))
        const url = `/order?${filterQueryParam}`
        router.push(url)

        setTimeout(async () => {
            await services.order.list(filterQueryParam)
            .then((response) => {
                const data = response.data
                limit.value = parseInt(data.limit)
                page.value = parseInt(data.page)
                total_all.value = parseInt(data.total_all)
                total_fitered.value = parseInt(data.total_fitered)
                rows.value = data.list
                setTimeout(() => {
                    loading.value = false    
                }, 500)
            })
            .catch((error) => {
                console.log(error)
            })
        }, 1500)

    }

    function remove(){
        swal.fire({
            title: "Are you sure ?",
            text: "Please confirm that you accept these terms.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, cancel it!",
            showLoaderOnConfirm: true,
        }).then(async (result) => {
            if (result.isConfirmed) {
                await services.order
                    .cancel()
                    .then((result) => {
                        const msg = result.data.message
                        swal.fire({
                            title: "Success!!",
                            text: msg,
                            icon: "success"
                        })
                        props.loadOrder()
                        loadData()
                    })
            }
        })
    }

    function detail(id){
        router.push(`/order/${id}`)
    }

    onMounted(() => {

    if (queryString.parse(location.search)) {
        
            const parsed = queryString.parse(location.search);
            
            if (parsed.limit !== undefined) {
                limit.value = parsed.limit
            }

            if (parsed.page !== undefined) {
                page.value = parsed.page
            }

            if (parsed.search !== undefined) {
                search.value = parsed.search
            }

            if (parsed.sort !== undefined) {
                sort.value = parsed.sort
            }

            if (parsed.dir !== undefined) {
                dir.value = parsed.dir
            }
        } 

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
                            <li class="breadcrumb-item active" aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </main>
    <main class="flex-shrink-0 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sort By</label>
                    <select v-model="sort" class="form-control">
                        <option disabled value="id">Please Select Item</option>
                        <option value="created_at">Order Date</option>
                        <option value="invoice_number">Order Number</option>
                        <option value="total_item">Total Product</option>
                        <option value="total_paid">Total Payment</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sort Direction</label>
                    <select v-model="dir" class="form-control">
                        <option disabled value="">Please Select Item</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Limit</label>
                    <select v-model="limit" class="form-control">
                        <option disabled value="0">Please Select Item</option>
                        <option value="10">10 Rows</option>
                        <option value="25">25 Rows</option>
                        <option value="50">50 Rows</option>
                        <option value="100">100 Rows</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Search By Keyword</label>
                    <input type="text" v-model="search"  placeholder='Search here..' class="form-control" aria-label="Text input with dropdown button">
                </div>
            </div>
            <div class="row mt-4">
               <div class="col-md-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Order Date</th>
                                <th>Order Number</th>
                                <th class="text-center">Total Item</th>
                                <th class="text-center">Total Payment</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody v-if="loading">
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span><i class="fas fa-circle-notch fa-spin me-2"></i>Loading fetching data....</span>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-if="rows.length === 0">
                                <td colspan="7" class="text-center">
                                    <span>No Data Available.</span>
                                </td>
                            </tr>
                            <tr v-else v-for="(row, index) in rows">
                                <td class="text-center">{{ ++index }}</td>
                                <td>{{ row.created_at }}</td>
                                <td>{{ row.invoice_number }}</td>
                                <td class="text-center">{{ row.total_item }}</td>
                                <td class="text-end">{{ parseFloat(row.total_paid).toFixed(2) }}</td>
                                <td class="text-center">
                                    <span v-if="row.status === 1">
                                        <span class="badge bg-success">Completed</span>
                                    </span>
                                    <span v-else>
                                        <span class="badge bg-danger">Draft</span>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span v-if="row.status === 1">
                                    <button @click="detail(row.id)" class="btn btn-sm btn-secondary me-1">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    </span>
                                    <span v-else>
                                        <button @click="detail(row.id)" class="btn btn-sm btn-secondary me-1">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button @click="remove(row.id)" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="float-start">
                            <div v-if="total_all > limit">
                                <Vue3BsPaginate
                                    :total="parseInt(total_filtered)"
                                    v-model="page"
                                    :perPage="parseInt(limit)"
                                    :onChange="loadData"
                                    alignment="left"
                                    ref="pagination"
                                />  
                            </div>
                        </div>
                        <div class="float-end">
                            <button @click="loadData" class="btn btn-primary" :class="loading ? 'disabled' :  ''">
                                <i class="fas fa-filter me-1"></i>Apply Filter
                            </button>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </main>
</template>