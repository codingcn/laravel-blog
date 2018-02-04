<template>
    <div v-loading.body="loading">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/option' }">系统设置</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-box">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="站点名称">
                    <el-input v-model="form[0]"></el-input>
                </el-form-item>
                <el-form-item label="IPC备案号">
                    <el-input v-model="form.title"></el-input>
                </el-form-item>
                <el-form-item label="关于" prop="desc">
                    <el-input type="textarea" v-model="form.summary"></el-input>
                </el-form-item>
                <el-form-item label="网站LOGO">
                    <el-upload
                            list-type="picture-card"
                            name="cover"
                            class="upload-cover"
                            :multiple="false"
                            :on-preview="handlePictureCardPreview"
                            :on-change="handleChange"
                            :on-remove="handleRemove"
                            :file-list="file_list"
                            :on-success="handleUploadSuccess"
                            :headers="headers"
                            v-bind:action=" upload_action_cover"
                    >
                        <i class="el-icon-plus"></i>
                        <el-dialog v-model="dialogVisible" size="tiny">
                            <img width="100%" :src="dialogImageUrl" alt="">
                        </el-dialog>
                    </el-upload>
                </el-form-item>
                <el-form-item label="推荐">
                    <el-switch on-text="on" off-text="off" v-model="form.recommend"></el-switch>
                </el-form-item>
                <el-form-item label="立即发布">
                    <el-switch on-text="on" off-text="off" v-model="form.status"></el-switch>
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
    import editor from './Editor'
    import qs from 'qs';

    export default {
        components: {
            editor
        },
        beforeMount() {
            this.getOption()
        },
        data: function () {
            return {
                loading: false,
                form: {
                },
                upload_action_cover: this.$difines.root_url + '/api/admin/article/upload-cover',
                file_list: [],
                upload_action_editor: this.$difines.root_url + '/api/admin/article/upload-editor',   // 图片上传服务器地址
                dialogImageUrl: '',
                dialogVisible: false,
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            }
        },
        methods: {
            getOption() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/options',
                    method: 'get',
                }).then(response => {
                    let data = response.data.data
                    this.form.category_options = data
                    this.loading = false
                }).catch(response => {
                    this.loading = false
                });
            },
            handleChange(file, file_list) {
                this.file_list.splice(0)
                this.file_list.push(file)
            },
            handleRemove(file, file_list) {
                console.log(file.response.data.cover_path)
                console.log(file_list)
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/upload-cover-del',
                    method: 'post',
                    data: {
                        cover_path: file.response.data.cover_path
                    }
                }).then(response => {
                    this.form.cover=''
                    if (response.data.err_no !== 0) {
                        this.$notify.error({
                            title: '错误',
                            message: '移除文件出错了'
                        });
                    }
                }).catch(response => {
                });
            },
            handlePictureCardPreview(file) {
                console.log(file);
            },
            handleUploadSuccess(file, file_list) {
                this.form.cover = file.data.cover_path
            },
            onSubmit() {
//                let data = this.form
                let data = {
                    recommend: this.form.recommend ? 2 : 1,
                    status: this.form.status ? 2 : 1,
                    cover: this.form.cover,
                    content_html: this.form.content_html,
                    category_id: this.form.category_id,
                    content_md: this.form.content_md,
                    title: this.form.title,
                    summary: this.form.summary,
                    tags: this.form.tags,
                }

                // 编辑
                if (this.$route.params.id) {
                    data.id = this.form.id
                    this.$axios({
                        url: this.$difines.root_url + '/api/admin/article/edit/' + data.id,
                        method: 'put',
                        data: qs.stringify(data)
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
                } else {
                    this.$axios({
                        url: this.$difines.root_url + '/api/admin/article/store',
                        method: 'post',
                        data: qs.stringify(data)
                    }).then(response => {
                        console.log(response.data)
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
    }
</script>
<style>
    .el-upload-dragger {
        width: auto;
        height: auto;
    }
</style>