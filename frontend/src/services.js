import axios from "axios"

const http = (auth_token) => {

    let headers = {
        "Content-type": "application/json"
    }

    if (localStorage.getItem('auth_token')) {
        auth_token = localStorage.getItem('auth_token')
    }

    if (auth_token !== undefined && auth_token !== null) {
        headers = {
            ...headers,
            "Authorization ": `Bearer ${auth_token}`
        }
    }

    return axios.create({ baseURL: `${import.meta.env.VITE_APP_BACKEND_URL}`, headers: headers })
}

const ping = async () => {
    return await http().get("/api/ping")
}

const expiredMessage = `Your session has been expired. Please log in again to continue using the app`

const getFile = (param) => {
    return `${import.meta.env.VITE_APP_BACKEND_URL}/stream/${param}`
}

const auth = {
    login: async (body) => {
        return await http().post("/api/auth/login", body)
    },
    register: async (body) => {
        return await http().post("/api/auth/register", body)
    },
    confirm: async (token) => {
        return await http().get(`/api/auth/confirm/${token}`)
    },
    resend: async (token) => {
        return await http().get(`/api/auth/resend/${token}`)
    },
    forgot: async (body) => {
        return await http().post("/api/auth/email/forgot", body)
    },
    reset: async (token, body) => {
        return await http().post(`/api/auth/email/reset/${token}`, body)
    },
}

const profile = {
    detail: async () => {
        return await http().get("/api/profile/detail")
    },
    activity: async () => {
        return await http().get("/api/profile/activity")
    },
    changePassword: async (body) => {
        return await http().post("/api/profile/password", body)
    },
    changeProfile: async (body) => {
        return await http().post("/api/profile/update", body)
    },
    upload: async (file) => {

        const auth_token = localStorage.getItem('auth_token')
        const formData = new FormData();

        formData.append('file_image', file);

        let headerUpload = {
            'Content-Type': 'multipart/form-data',
            "Authorization ": `Bearer ${auth_token}`
        }

        return await axios.create({ baseURL: `${import.meta.env.VITE_APP_BACKEND_URL}`, headers: headerUpload }).post("/api/profile/upload", formData)
    },
}

const home = {
    component: async () => {
        return await http().get("/api/home/component")
    },
    page: async () => {
        return await http().get("/api/home/page")
    },
    newsletter: async (data) => {
        return await http().post("/api/newsletter/send", data)
    },
}

const store = {
    list: async (params) => {
        return await http().get(`/api/shop/list?${params}`)
    },
    filter: async () => {
        return await http().get("/api/shop/filter")
    },
}

const order = {
    list: async (params) => {
        return await http().get(`/api/order/list?${params}`)
    },
    billing: async (id) => {
        return await http().get(`/api/order/billing/${id}`)
    },
    product: async () => {
        return await http().get(`/api/order/product`)
    },
    cancel: async () => {
        return await http().get(`/api/order/cancel`)
    },
    cartDetail: async (id) => {
        return await http().get(`/api/order/cart/${id}`)
    },
    cartAdd: async (id, data) => {
        return await http().post(`/api/order/cart/${id}`, data)
    },
    cartDelete: async (id) => {
        return await http().delete(`/api/order/cart/${id}`)
    },
    wishlist: async (id) => {
        return await http().get(`/api/order/wishlist/${id}`)
    },
    detail: async (id) => {
        return await http().get(`/api/order/detail/${id}`)
    },
    listReview: async (id) => {
        return await http().get(`/api/order/review/${id}`)
    },
    createReview: async (id, data) => {
        return await http().post(`/api/order/review/${id}`, data)
    },
    checkout: async (id, data) => {
        return await http().post(`/api/order/checkout/${id}`, data)
    },
}

export default {
    ping,
    getFile,
    expiredMessage,
    auth,
    profile,
    store,
    home,
    order
}