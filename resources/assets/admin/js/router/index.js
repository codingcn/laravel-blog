import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);
import SignIn from '../components/page/SignIn.vue';
import Home from '../components/common/Home.vue';
import Users from '../components/page/Users.vue';
import Index from '../components/page/Index.vue';
import Categories from '../components/page/Categories.vue';
import Category from '../components/page/Category.vue';
import Articles from '../components/page/Articles.vue';
import Article from '../components/page/Article.vue';
import Settings from '../components/page/Settings.vue';


let router = new Router({
    mode: 'history',
    base: '/admin/',
    // mode: 'hash',
    routes: [
        {
            path: '/sign-in',
            // component: resolve => {require(['../components/page/SignIn.vue'], resolve)},
            component: SignIn,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/',
            meta: {
                forAuth: true
            },
            component: Home,
            children: [
                {
                    path: '',
                    component: Index
                },
                {
                    path: '/users',
                    component: Users     // 分类列表
                },
                {
                    path: '/categories',
                    component: Categories     // 分类列表
                },
                {
                    name:'/category',
                    path: '/category/:id',
                    component: Category     // 分类更新
                },
                {
                    name:'/category-create',
                    path: '/category-create',
                    component: Category     // 分类创建
                },
                {
                    path: '/articles',
                    component: Articles     // 文章列表
                },
                {
                    name: 'article',
                    path: '/article/:id',
                    component: Article     // 文章更新
                },
                {
                    name: 'article-create',
                    path: '/article-create',
                    component: Article     // 文章新建
                },
                {
                    name: 'settings',
                    path: '/settings',
                    component: Settings     // 文章新建
                }
            ]
        }
    ]
})
router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({path: ''})
            } else {
                next()
            }
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({path: '/sign-in'})
            } else {
                next()
            }
        } else {
            next()
        }
        //     if (!localStorage.getItem('access_token') && localStorage.getItem('refresh_token')) {
        //         console.log(1)
        //         const data = {
        //             refresh_token: localStorage.getItem('refresh_token'),
        //             scope: '*'
        //         };
        //         axios.post('http://localhost/blog/public/api/oauth/refresh-token', data)
        //             .then(response => {
        //                 // 刚开始踩坑了，js的时间戳微妙为单位，而且木有时区，和PHP不一样
        //                 let js_time = Math.round(new Date().getTime() / 1000 - 28800)
        //                 Vue.auth.setToken(response.data.access_token, response.data.refresh_token, response.data.expires_in + js_time);
        //                 next()
        //             })
        //             .catch(response => {
        //                 next({path: '/login'})
        //             });
        //     }
    }
)
export default router