<template>
    <section class="main">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>文章管理</el-breadcrumb-item>
                <el-breadcrumb-item>文章列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div>
            <div style="float: right;margin-bottom: 2rem">
                <router-link to="/category-create"><el-button type="primary" icon="plus">添加分类</el-button></router-link>
            </div>
            <el-table
                    v-loading="loading"
                    :data="tableData"
                    style="width: 100%">
                <el-table-column width="60">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="分类名"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="serial_number"
                        label="排序"
                        width="180">
                </el-table-column>
                <el-table-column
                        label="操作">
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
        beforeMount(){
            this.getCategories()
        },
        data() {
            return {
                loading: false,
                tableData: [],
                page:{
                }
            }
        },
        methods: {
            currentChange(p){
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/categories?page='+p,
                    method: 'get'
                }).then(response => {
                    this.tableData = response.data.data.data
                    this.page.pageSize=response.data.data.per_page
                    this.page.total=response.data.data.total
                    this.loading = false
                }).catch(response => {
                });
            },
            getCategories(){
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/categories',
                    method: 'get'
                }).then(response => {
                    // 提示: 如果这个位置console.log()那么就会出错。。
                    this.tableData = response.data.data.data
                    this.page.pageSize=response.data.data.per_page
                    this.page.total=response.data.data.total
                    this.loading = false
                }).catch(response => {

                });
            },
            handleEdit(index, row) {
                this.$router.push({name: 'category', params: {id: row.id}})
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

