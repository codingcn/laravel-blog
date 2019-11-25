export default function (Vue) {
    Vue.auth = {
        // set token
        setToken: (access_token, refresh_token, expires_in) => {
            localStorage.setItem('access_token', access_token)
        },
        // get token
        getToken() {
            return localStorage.getItem('access_token')
        },
        // destory token
        destroyToken: () => {
            localStorage.removeItem('access_token')
        },
        // isAuthenticated
        isAuthenticated() {
            if (this.getToken())
                return true
            else
                return false
        }
    }
    Object.defineProperties(Vue.prototype, {
        $auth: {
            get() {
                return Vue.auth
            }
        }
    })

}