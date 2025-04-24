import axios from "axios"

const auth_token = localStorage.getItem('auth_token')

const http = () => {

    let headers = {
        "Content-type": "application/json"
    }

    if(auth_token !== null){
        headers  = {
            ...headers,
            "Authorization ": `Bearer ${auth_token}`
        }
    }

    return axios.create({baseURL: `${import.meta.env.VITE_APP_BACKEND_URL}`, headers: headers})
}

const ping = async () => {
    return await http().get("/api/ping")
}

const auth = {
    login: async (body) => {
        return await http().post("/api/auth/login", body)
    },
    register: async (body) => {
        return await http().post("/api/auth/register", body)
    },
    confirm: async (token) => {
        return await http().post(`/api/auth/confirm/${token}`)
    },
    resend: async (token) => {
        return await http().post(`/api/auth/resend/${token}`)
    },
    forgot: async (body) => {
        return await http().post("/api/auth/email/forgot", body)
    },
    reset: async (token, body) => {
        return await http().post(`/api/auth/email/reset/${token}`, body)
    },
}

export default {
    ping,
    auth
}