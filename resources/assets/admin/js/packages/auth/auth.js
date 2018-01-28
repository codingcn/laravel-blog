export default function (Vue) {
    Vue.auth = {
        // set token
        setToken: (access_token, refresh_token, expires_in) => {
            localStorage.setItem('access_token', access_token)
            localStorage.setItem('refresh_token', refresh_token)
            localStorage.setItem('expires_in', expires_in)
        },
        // get token
        getToken() {
            let access_token = localStorage.getItem('access_token')
            // let refresh_token = localStorage.getItem('refresh_token')
            let expires_in = localStorage.getItem('expires_in')
            if (!access_token || !expires_in) {
                return null
            }
            //如果访问token过期
            //刚开始踩坑了，php和js的时间戳不一样（单位和时区都不一样）
            // console.log(expires_in)
            // console.log(Math.round(new Date().getTime() / 1000 - 28800))
            if (expires_in < Math.round(new Date().getTime() / 1000 - 28800)) {
                localStorage.removeItem('access_token')
                localStorage.removeItem('expires_in')
                return false
            } else {
                return access_token
            }
        },
        // destory token
        destoryToken: () => {
            localStorage.removeItem('access_token')
            localStorage.removeItem('expires_in')
            localStorage.removeItem('refresh_token')

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