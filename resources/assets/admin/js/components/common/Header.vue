<template>
    <div class="header">
        <el-menu
                :default-active="activeIndex2"
                class="el-menu-demo"
                mode="horizontal"
                @select="handleSelect"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#42b983">
            <el-menu-item index="1" class="logo"><router-link :to="{path:'/admin'}">Dash Board</router-link></el-menu-item>
            <el-menu-item index="3"><a href="/" target="_blank">网站首页</a></el-menu-item>
            <el-menu-item index="3"><router-link :to="{path:'/'}">用户管理</router-link></el-menu-item>
            <el-menu-item index="4"><router-link :to="{path:'/articles'}">文章管理</router-link></el-menu-item>
            <el-submenu index="20" class="user-info">
                <template slot="title">
                    <span class="el-dropdown-link" trigger="click">
                    <img class="user-avatar" v-bind:src="admin.avatar">
                        {{admin.username}}
                    </span>
                </template>
                <el-menu-item index="2-1"><router-link :to="{path:'/profile'}">修改信息</router-link></el-menu-item>
                <el-menu-item index="sign_out" command="sign_out">退出</el-menu-item>
            </el-submenu>
        </el-menu>
    </div>
</template>
<script>
    export default {
        created() {
            let self = this;
            self.$nextTick(() => {
                let admin = JSON.parse(localStorage.getItem('admin'))
                self.admin = admin
            })
        },
        data() {
            return {
                avatar: '',
                admin: {
                    username: '',
                    avatar: ''
                },
                logo:this.$difines.root_url+'/static/home/img/logo.png',
                activeIndex: '1',
                activeIndex2: '1'
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                if (key === 'sign_out') {
                    this.$auth.destoryToken()
                    localStorage.removeItem('admin')
                    this.$notify({
                        title: '成功',
                        message: '注销成功',
                        type: 'success'
                    });
                    this.$router.push('/sign-in');
                }
            }
        }
    }
</script>
<style scoped>
    .header .logo {
        float: left;
        width: 200px;
        text-align: center;
        font-weight: bold;
        font-size: 1.3rem;
    }
    .header a{
        text-decoration: none;
    }

    .user-info {
        float: right;
        padding-right: 50px;
        font-size: 16px;
        color: #fff;
    }

    .user-info .el-dropdown-link {
        position: relative;
        display: inline-block;
        padding-left: 3rem;
        color: #fff;
        cursor: pointer;
        vertical-align: middle;
    }

    .user-info .user-avatar {
        position: absolute;
        top: 1rem;
        left: 0;
        width: 2rem;
        height: 2rem;
        line-height: 2rem;
        border-radius: 50%;
    }

    .el-dropdown-menu__item {
        text-align: center;
    }
</style>
