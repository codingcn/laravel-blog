export default {
    install(Vue, options) {
        Vue.prototype.$difines = {
            root_url: location.protocol + '//' + location.host,
            sex: 'woman'
        }
    }
}
