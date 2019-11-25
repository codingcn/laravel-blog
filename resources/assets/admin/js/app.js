import defines from './common/defines'
import auth from './packages/auth/auth';
// import ElementUI from 'element-ui'
import router from './router'
import axios from 'axios';
import {
    Pagination,
    Dialog,
    Button,
    Menu,
    MenuItem,
    Submenu,
    MenuItemGroup,
    Input,
    Switch,
    Select,
    Option,
    Table,
    TableColumn,
    Tooltip,
    Breadcrumb,
    BreadcrumbItem,
    Form,
    FormItem,
    Tabs,
    TabPane,
    Tag,
    Upload,
    Loading,
    Notification,
} from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

// Vue.use(ElementUI)
Vue.use(Pagination)
Vue.use(Dialog)
Vue.use(Button)
Vue.use(Menu)
Vue.use(MenuItem)
Vue.use(Submenu)
Vue.use(MenuItemGroup)
Vue.use(Input)
Vue.use(Switch)
Vue.use(Select)
Vue.use(Option)
Vue.use(Table)
Vue.use(TableColumn)
Vue.use(Tooltip)
Vue.use(Breadcrumb)
Vue.use(BreadcrumbItem)
Vue.use(Form)
Vue.use(FormItem)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Tag)
Vue.use(Upload)
Vue.use(Loading.directive)
Vue.prototype.$loading = Loading.service
Vue.prototype.$notify = Notification


Vue.use(auth)
Vue.use(defines)
Vue.use(router)


axios.interceptors.request.use(
    config => {
        if (Vue.auth.getToken()) {  
        	// 判断是否存在token，如果存在的话，则每个http header都加上token
            config.headers.Authorization = 'Bearer ' + Vue.auth.getToken();
        }
        return config;
    },
    err => {
        return Promise.reject(err);
    }
);

// http response 拦截器
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response) {
            switch (error.response.status) {
                case 401: {
                    // 返回 401 清除token信息并跳转到登录页面
                    Vue.auth.destroyToken();
                    Notification.error({
                        title: '权限错误',
                        message: '请重新登陆'
                    });
                    router.push({
                        path: '/sign-in'
                    })
                }
            }
            return Promise.reject(error.response)   // 返回接口返回的错误信息
        }

    }
);
Vue.prototype.$axios = axios;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    router
});
