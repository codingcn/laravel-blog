import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const SignIn = () => import('../components/page/SignIn.vue');
const Home = () => import('../components/common/Home.vue');
const Users = () => import('../components/page/Users.vue');
const Index = () => import('../components/page/Index.vue');
const Categories = () => import('../components/page/Categories.vue');
const Articles = () => import('../components/page/Articles.vue');
const Article = () => import('../components/page/Article.vue');
const Links = () => import('../components/page/Links.vue');
const Settings = () => import('../components/page/Settings.vue');
const AdminUser = () => import('../components/page/AdminUser.vue');


let router = new Router({
    mode: 'history',
    base: '/admin/',
    routes: [
        {
            path: '/sign-in',
            component: SignIn,
            meta: {
                forVisitors: true
            }
        },
        {
            path: '/',
            component: Home,
            meta: {
                forAuth: true
            },
            children: [
                {
                    path: '/index',
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
                    path: '/articles',
                    component: Articles     // 文章列表
                },
                {
                    name: 'articles/edit',
                    path: '/articles/:id/edit',
                    component: Article     // 文章更新
                },
                {
                    name: 'articles/create',
                    path: '/articles/create',
                    component: Article     // 文章新建
                },
                {
                    name: 'links',
                    path: '/links',
                    component: Links
                }
                ,
                {
                    name: 'settings',
                    path: '/settings',
                    component: Settings
                },
                {
                    name: 'admin-user',
                    path: '/admin-user',
                    component: AdminUser
                }
            ]
        }
    ]
})
router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({path: '/index'})
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
    }
)
export default router