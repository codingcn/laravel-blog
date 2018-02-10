<template>
    <div v-loading.body="loading">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/articles' }">分类管理</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/articles' }">分类列表</el-breadcrumb-item>
                <el-breadcrumb-item>编辑文章</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-box">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="分类名">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input v-model="form.serial_number"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">提交</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </div>

    </div>
</template>

<script>
    import qs from 'qs';

    export default {
        data: function () {
            return {
                loading: false,
                form: {
                    name: '',
                    serial_number: ''
                }
            }
        },
        methods: {
            onSubmit() {
                // 编辑
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/categories',
                    method: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    },
                    data: qs.stringify(this.form)
                }).then(response => {
                    if (response.data.err_no === 0) {
                        this.$notify.success({
                            title: '成功',
                            message: response.data.err_msg
                        });
                        this.$router.push({path: '/articles'})
                    } else {
                        this.$notify.error({
                            title: '失败',
                            message: response.data.err_msg
                        });
                    }
                }).catch(response => {
                });
            }
        }
    }
</script>
<style>

</style>