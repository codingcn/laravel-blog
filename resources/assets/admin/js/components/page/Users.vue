<template>
    <section class="main">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>用户管理</el-breadcrumb-item>
                <el-breadcrumb-item>用户列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div>
            <el-form :inline="true" :model="searchForm" class="demo-form-inline">
                <el-form-item label="">
                    <el-input v-model="searchForm.keywords" placeholder="请输入用户名/手机号/邮箱..."></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">查询</el-button>
                </el-form-item>
            </el-form>
            <div style="margin-top: 15px;">

            </div>
            <el-table
                    v-loading="loading"
                    :data="tableData"
                    style="width: 100%">
                <el-table-column width="60">
                </el-table-column>
                <el-table-column
                        prop="id"
                        label="ID"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="username"
                        label="用户名"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="email"
                        label="邮箱"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="phone"
                        label="手机号"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="注册时间"
                        width="180">
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">编辑
                        </el-button>
                        <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination
                    layout="prev, pager, next"
                    :page-size="page.pageSize"
                    @current-change="currentChange"
                    :total="page.total">
            </el-pagination>
        </div>
    </section>
</template>

<script type="text/ecmascript-6">
    export default {
        beforeMount() {
            this.getUsers()
        },
        data() {
            return {
                loading: false,
                tableData: [],
                page: {},
                searchForm: {
                    keywords: '',
                }
            }
        },
        methods: {
            onSubmit() {
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/users/search',
                    params: {
                        keywords: this.searchForm.keywords
                    },
                    method: 'get'
                }).then(response => {
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
                    this.loading = false
                }).catch(response => {
                });
            },
            currentChange(p) {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/users?page=' + p,
                    method: 'get'
                }).then(response => {
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
                    this.loading = false
                }).catch(response => {
                });
            },
            getUsers() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/users',
                    method: 'get'
                }).then(response => {
                    // 提示: 如果这个位置console.log()那么就会出错。。
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
//                    console.log(this.response.data.data)
//                    this.tableData.recommend = data.recommend === 2 ? '是' : '否'
//                    this.tableData.status = data.status === 2 ?'是' : '否'
//                    this.tableData.cover_path = data.cover
//                    console.log(this.tableData)
                    this.loading = false
                }).catch(response => {

                });

            },
            handleEdit(index, row) {
                this.$router.push({name: 'user', params: {id: row.id}})
            },
            handleDelete(index, row) {

            }
        }
    }
</script>

<style>
    .el-tag {
        margin-right: 0.8rem;
    }

    .demo-table-expand {
        font-size: 0;
    }

    .demo-table-expand label {
        width: 90px;
        color: #99a9bf;
    }

    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 50%;
    }
</style>

