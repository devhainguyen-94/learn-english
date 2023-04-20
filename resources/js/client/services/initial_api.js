import axios from 'axios'
const API_URL = `${process.env.BASE_LINK}`
const token = 'test'
const axiosApi = axios.create({
    baseURL: API_URL,
    headers: { Authorization: `Bearer ${token}` }
})

axiosApi.interceptors.response.use(
    (response) => response,
    (error) => Promise.reject(error)
)

export function updateToken() {
    const session = localStorage.getItem('lunvs:20:session') || ''
    var tokenNew = ''
    if (session) {
        const { token } = JSON.parse(session)
        tokenNew = token
        axiosApi.defaults.headers = { Authorization: `Bearer ${tokenNew}` }
    }
}

export async function get(url, config = {}) {
    return await axiosApi.get(url, { ...config }).then((response) => {
        return { ...response.data, status: response.status }
    })
}

export async function post(url, data, config = {}) {
    return axiosApi.post(url, { ...data }, { ...config }).then((response) => {
        return { ...response.data, status: response.status }
    })
}

export async function put(url, data, config = {}) {
    return axiosApi.put(url, { ...data }, { ...config }).then((response) => {
        return { ...response.data, status: response.status }
    })
}

export async function del(url, config = {}) {
    return await axiosApi.delete(url, { ...config }).then((response) => {
        return { ...response.data, status: response.status }
    })
}
