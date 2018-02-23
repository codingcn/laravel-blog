<template>
    <div class="sidebar">
        <div class="contraction" @click="isCollapseClick">
            <i class="fa fa-ellipsis-h"></i>
            <span>收展</span>
        </div>

        <el-menu unique-opened router class="el-menu-vertical" @open="handleOpen"
                 @close="handleClose" background-color="#545c64" text-color="#fff" active-text-color="#42b983"
                 :collapse="isCollapse">

            <template v-for="item in items">
                <template v-if="item.subs">
                    <el-submenu :index="item.index">
                        <template slot="title">
                            <i :class="item.icon"></i>
                            <span slot="title">{{ item.title }}</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item v-for="(subItem,i) in item.subs" :key="i" :index="subItem.index">
                                {{ subItem.title }}
                            </el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                </template>
                <template v-else>
                    <el-menu-item :index="item.index">
                        <i :class="item.icon"></i>
                        <span slot="title">{{ item.title }}</span>
                    </el-menu-item>
                </template>
            </template>

        </el-menu>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isCollapse: false,
                items: [
                    {
                        icon: 'fas fa-tachometer-alt',
                        index: 'index',
                        title: '控制面板'
                    },
                    {
                        icon: 'fas fa-users',
                        index: 'member',
                        title: '用户管理',
                        subs: [
                            {
                                index: '/users',
                                title: '用户列表'
                            }
                        ]
                    },
                    {
                        icon: 'el-icon-tickets',
                        index: 'article',
                        title: '文章管理',
                        subs: [
                            {
                                index: '/categories',
                                title: '文章分类'
                            },
                            {
                                index: '/articles',
                                title: '文章管理'
                            }
                        ]
                    },
                    {
                        icon: 'fas fa-link',
                        index: 'link',
                        title: '运营管理',
                        subs: [
                            {
                                index: '/links',
                                title: '友链列表'
                            }
                        ]
                    },
                    {
                        icon: 'fas fa-cogs',
                        index: '/settings',
                        title: '站点设置'
                    }
                ]
            }
        },
        computed: {},
        methods: {
            handleOpen(key, keyPath) {
//                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
//                console.log(key, keyPath);
            },
            isCollapseClick() {
                // 给父组件传参，控制content收缩样式
                this.isCollapse = !this.isCollapse
                this.$emit('sidebarCollapse', this.isCollapse);
            }
        }
    }
</script>

<style scoped>
    .contraction{
        cursor: pointer;
        height: 2rem;
        line-height: 2rem;
        background-color: rgb(84, 92, 100);
        color: #ffffff;
        padding-left: 20px;
    }
    .contraction span {
        padding-left: 12px;
    }

    .el-menu-vertical:not(.el-menu--collapse) {
        width: 200px;
        min-height: 400px;
    }

    .sidebar {
        display: block;
        position: absolute;
        width: 200px;
        left: 0;
        top: 60px;
        bottom: 0;
        background: #2E363F;
    }

    .sidebar > ul {
        height: 100%;
    }

    .sidebar i[class^="fa"] {
        margin-right: 5px;
        width: 24px;
        text-align: center;
        font-size: 18px;
    }
</style>
