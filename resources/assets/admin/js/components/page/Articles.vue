<template>
    <section class="main">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>文章管理</el-breadcrumb-item>
                <el-breadcrumb-item>文章列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div v-loading="loading">
            <div style="float: right;margin-bottom: 2rem">
                <router-link to="/articles/create">
                    <el-button type="primary" icon="plus">添加文章</el-button>
                </router-link>
            </div>
            <el-table
                    :data="tableData"
                    style="width: 100%"
            >
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <el-form label-position="left" inline class="demo-table-expand">
                            <el-form-item label="文章ID">
                                <span>{{ props.row.id }}</span>
                            </el-form-item>
                            <el-form-item label="标签">
                                <el-tag type="primary" v-for="item in props.row.tags" :key="item.id">{{ item.name }}
                                </el-tag>
                            </el-form-item>
                            <el-form-item label="描述">
                                <span>{{ props.row.summary }}</span>
                            </el-form-item>
                        </el-form>
                    </template>
                </el-table-column>
                <el-table-column
                        label="分类"
                        width="80"
                        prop="article_category.name">
                </el-table-column>
                <el-table-column
                        label="标题"
                        width="200"
                        prop="title">
                </el-table-column>
                <el-table-column
                        label="推荐状态"
                        width="80"
                        prop="format_recommend">
                </el-table-column>
                <el-table-column
                        label="发布状态"
                        width="80"
                        prop="format_publish_status">
                </el-table-column>
                <el-table-column
                        label="点击量"
                        width="80"
                        prop="page_views">
                </el-table-column>
                <el-table-column
                        label="更新时间"
                        width="180"
                        prop="updated_at">
                </el-table-column>
                <el-table-column
                        label="创建时间"
                        width="180"
                        prop="created_at">
                </el-table-column>
                <el-table-column
                        width="250"
                        label="操作">
                    <template slot-scope="scope">
                        <el-button
                                size="small"
                                @click="handleEdit(scope.$index, scope.row)">编辑
                        </el-button>
                        <el-button
                                size="small"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删除
                        </el-button>
                        <el-button
                                size="small"
                                @click="handlePreview(scope.$index, scope.row)">预览
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
        mounted() {
            this.getArticles()
        },
        data() {
            return {
                loading: false,
                tableData: [],
                page: {}
            }
        },
        methods: {
            currentChange(p) {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/articles?page=' + p,
                    method: 'get',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    }
                }).then(response => {
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
                    this.loading = false
                }).catch(response => {
                });
            },
            getArticles() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/articles',
                    method: 'get',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    }
                }).then(response => {
                    this.tableData = response.data.data.data;
                    this.page.pageSize = response.data.data.per_page;
                    this.page.total = response.data.data.total;
                    this.loading = false
                }).catch(response => {
                    console.log(response)
                    this.loading = false
                });


            },
            handleEdit(index, row) {
                this.$router.push({name: 'articles/edit', params: {id: row.id}})
            },
            handleDelete(index, row) {
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/articles/' + row.id,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    }
                }).then(response => {
                    if (response.data.err_no == 0) {
                        this.$notify.success({
                            title: '成功',
                            message: '文章删除成功'
                        });
                        this.getArticles()
                    } else {
                        this.$notify.error({
                            title: '错误',
                            message: '文章删除失败'
                        });
                        this.getArticles()
                    }
                }).catch(response => {
                    this.$notify.error({
                        title: '错误',
                        message: '文章删除失败'
                    });
                    this.getArticles()
                });
            },
            handlePreview(index, row) {
                window.open("/articles/" + row.id)
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

