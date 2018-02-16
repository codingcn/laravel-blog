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
                <el-button type="primary" icon="plus"  @click="dialogCreateFormVisible = true">添加分类</el-button>
            </div>
            <el-table
                    v-loading="loading"
                    :data="tableData"
                    style="width: 100%">
                <el-table-column width="60">
                </el-table-column>
                <el-table-column
                        prop="id"
                        label="分类ID"
                        width="180">
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
                        prop="updated_at"
                        label="更新时间"
                        width="200">
                </el-table-column>
                <el-table-column
                        width="250"
                        label="操作">
                    <template slot-scope="scope">
                        <el-button
                                size="small"
                                @click="handleEdit(scope.$index, scope.row);dialogEditFormVisible = true">
                            编 辑
                        </el-button>
                        <el-button
                                size="small"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">删 除
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
            <el-dialog title="修改分类" :visible.sync="dialogEditFormVisible">
                <el-form :model="editForm">
                    <el-form-item label="分类名称" :label-width="formLabelWidth">
                        <el-input v-model="editForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="分类序号" :label-width="formLabelWidth">
                        <el-input v-model="editForm.serial_number" auto-complete="off"></el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogEditFormVisible = false">取 消</el-button>
                    <el-button type="primary" @click="updateCategory();dialogEditFormVisible = false">确 定</el-button>
                </div>
            </el-dialog>
            <el-dialog title="新增分类" :visible.sync="dialogCreateFormVisible">
                <el-form :model="createForm">
                    <el-form-item label="分类名称" :label-width="formLabelWidth">
                        <el-input v-model="createForm.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="分类序号" :label-width="formLabelWidth">
                        <el-input v-model="createForm.serial_number" auto-complete="off"></el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogCreateFormVisible = false">取 消</el-button>
                    <el-button type="primary" @click="storeCategory();dialogCreateFormVisible = false">确 定</el-button>
                </div>
            </el-dialog>
        </div>
    </section>
</template>

<script type="text/ecmascript-6">
    export default {
        beforeMount() {
            this.getCategories()
        },
        data() {
            return {
                loading: false,
                tableData: [],
                page: {},
                dialogEditFormVisible: false,
                dialogCreateFormVisible: false,
                editForm: {
                    id: 0,
                    name: '',
                    serial_number: 0
                },
                createForm: {
                    name: '',
                    serial_number: 0
                },
                formLabelWidth: '120px'
            }
        },
        methods: {
            currentChange(p) {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article-categories?page=' + p,
                    method: 'get'
                }).then(response => {
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
                    this.loading = false
                }).catch(response => {
                });
            },
            getCategories() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article-categories',
                    method: 'get'
                }).then(response => {
                    // 提示: 如果这个位置console.log()那么就会出错。。
                    this.tableData = response.data.data.data
                    this.page.pageSize = response.data.data.per_page
                    this.page.total = response.data.data.total
                    this.loading = false

                }).catch(response => {
                    this.loading = false
                });

            },
            updateCategory() {
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article-categories/' + this.editForm.id,
                    method: 'PUT',
                    data: {
                        name: this.editForm.name,
                        serial_number: this.editForm.serial_number
                    }
                }).then(response => {
                    if (response.data.err_no !== 0) {
                        this.$notify.error({
                            title: '错误',
                            message: '分类修改失败'
                        });
                    } else {
                        this.$notify.success({
                            title: '成功',
                            message: '分类修改成功'
                        });
                        this.getCategories();
                    }
                }).catch(response => {
                });
            },
            storeCategory() {
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article-categories',
                    method: 'POST',
                    data: {
                        name: this.createForm.name,
                        serial_number: this.createForm.serial_number
                    }
                }).then(response => {
                    if (response.data.err_no !== 0) {
                        this.$notify.error({
                            title: '错误',
                            message: '分类添加失败'
                        });
                    } else {
                        this.$notify.success({
                            title: '成功',
                            message: '分类添加成功'
                        });
                        this.getCategories();
                    }
                }).catch(response => {
                });
            },
            handleEdit(index, row) {
                this.editForm = row;
            },
            handleDelete(index, row) {

            }
        }
    }
</script>

<style>
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

