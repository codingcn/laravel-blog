<template>
    <div>
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/articles' }">文章管理</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/articles' }">文章列表</el-breadcrumb-item>
                <el-breadcrumb-item>编辑文章</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div v-loading.body="loading" class="form-box">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="标题">
                    <el-input v-model="form.title"></el-input>
                </el-form-item>

                <el-form-item label="摘要" prop="desc">
                    <el-input type="textarea" v-model="form.summary"></el-input>
                </el-form-item>
                <el-form-item label="封面图">
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
                <el-form-item label="文本框">
                    <editor v-bind:markdown="form.content_md"
                            v-bind:upload_action_editor="upload_action_editor"
                            v-on:getEditorContent="getEditorContent"
                    >
                    </editor>
                </el-form-item>
                <el-form-item label="分类">
                    <el-select v-model="form.category_id" placeholder="请选择">
                        <el-option
                                v-for="item in form.category_options"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="标签">
                    <el-select
                            v-model="form.tags"
                            multiple
                            filterable
                            allow-create
                            remote
                            reserve-keyword
                            placeholder="请输入关键词"
                            :loading="tag_loading"
                            :remote-method="searchTag">
                        <el-option
                                v-for="item in form.tags_options"
                                :key="item.name"
                                :label="item.name"
                                :value="item.name">
                        </el-option>
                    </el-select>
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
            if (this.$route.params.id) {
                this.getArticle()
            } else {
                this.getArticleCategories()
            }
        },
        data: function () {
            return {
                loading: false,
                tag_loading: false,
                form: {
                    title: '',
                    summary: '',
                    recommend: '',
                    status: '',
                    content_md: '',
                    category_id: '',
                    category_options: [],
                    tags: [],
                    tags_options: [],
                    cover: ''
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
            searchTag(keywords) {
                if (keywords !== '') {
                    this.tag_loading = true;
                    this.$axios({
                        url: this.$difines.root_url + '/api/admin/article/tag/search',
                        method: 'get',
                        params: {
                            keywords: keywords
                        }
                    }).then(response => {
                        this.tag_loading = false;
                        let tags = response.data.data
                        this.form.tags_options = tags
                    }).catch(response => {
                    });
                } else {
                    this.form.tags_options = [];
                }
                console.log(this.form.tags_options)
            },
            getArticleCategories() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/categories/all',
                    method: 'get',
                }).then(response => {
                    let data = response.data.data
                    this.form.category_options = data
                    this.loading = false
                }).catch(response => {
                    this.loading = false
                });
            },
            getArticle() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/article/edit/' + this.$route.params.id,
                    method: 'get',
                }).then(response => {
                    let data = response.data.data
                    this.form = data
                    this.form.recommend = data.recommend === 2 ? true : false
                    this.form.status = data.status === 2 ? true : false
                    this.form.cover = data.cover
                    this.form.category_options = data.categories
//                    this.form.tags = data.tags
                    if(data.cover===''){
                        this.file_list.splice(0)
                    }else{
                        this.file_list.push({
                            name: data.title,
                            url: data.cover,
                        })
                    }
                    this.loading = false
                }).catch(response => {
                    this.loading = false
                });
            },
            getEditorContent(data) {
                this.form.content_md = data.content_md
                this.form.content_html = data.content_html
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