<template>
    <div v-loading.body="loading">
        <div class="crumbs">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/admin-user' }">管理员信息修改</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="form-box">
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="用户名">
                    <el-input v-model="form.username"></el-input>
                </el-form-item>
                <el-form-item label="旧密码">
                    <el-input v-model="form.old_password"></el-input>
                </el-form-item>
                <el-form-item label="新密码">
                    <el-input v-model="form.new_password"></el-input>
                </el-form-item>
                <el-form-item label="邮箱">
                    <el-input v-model="form.email"></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="form.phone"></el-input>
                </el-form-item>
                <el-form-item label="头像">
                    <el-upload
                            list-type="picture-card"
                            name="avatar"
                            class="upload-cover"
                            :multiple="false"
                            :on-preview="handlePictureCardPreview"
                            :on-change="handleChange"
                            :on-remove="handleRemove"
                            :file-list="file_list"
                            :on-success="handleUploadSuccess"
                            :headers="headers"
                            v-bind:action=" upload_action_avatar"
                    >
                        <i class="el-icon-plus"></i>
                        <el-dialog v-model="dialogVisible">
                            <img width="100%" :src="dialogImageUrl" alt="">
                        </el-dialog>
                    </el-upload>
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
        beforeMount() {
            this.getAdminUser()
        },
        data: function () {
            return {
                loading: false,
                form: {},
                upload_action_avatar: this.$difines.root_url + '/api/admin/admin-user/upload-avatar',
                file_list: [],
                dialogImageUrl: '',
                dialogVisible: false,
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            }
        },
        methods: {
            getAdminUser() {
                this.loading = true
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/admin-user',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    }
                }).then(response => {
                    let data=response.data.data
                    this.form=data;
                    localStorage.setItem('admin_user', JSON.stringify(data));
                    if(data.avatar===''){
                        this.file_list.splice(0)
                    }else{
                        this.file_list.push({
                            name: 'avatar',
                            url: data.avatar,
                        })
                    }
                    this.loading = false
                }).catch(response => {
                });

            },
            handleChange(file, file_list) {
                this.file_list.splice(0)
                this.file_list.push(file)
            },
            handleRemove(file, file_list) {
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/settings/upload-avatar-delete',
                    method: 'POST',
                    data: {
                        avatar: file.url
                    }
                }).then(response => {
                    if (response.data.err_no !== 0) {
                        this.$notify.error({
                            title: '错误',
                            message: '移除文件出错了'
                        });
                    } else {
                        this.$notify.success({
                            title: '成功',
                            message: '移除文件成功'
                        });
                        this.form.avatar = ''
                    }
                }).catch(response => {
                });
            },
            handlePictureCardPreview(file) {
                // console.log(file);
            },
            handleUploadSuccess(response, file, fileList) {
                this.file_list.splice(0)
                this.file_list.push(file)
                this.form.avatar = response.data.avatar
            },
            onSubmit() {
                console.log(this.form)
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/admin-user',
                    method: 'PUT',
                    data: qs.stringify(this.form)
                }).then(response => {
                    if (response.data.err_no === 0) {
                        if (response.data.data.change_password==='yes'){
                            this.$notify.success({
                                title: '成功',
                                message: '修改成功，请重新登录'
                            });
                            this.$auth.destoryToken()
                            localStorage.removeItem('admin_user')
                            this.$router.push('/sign-in');
                        }else{
                            this.$notify.success({
                                title: '成功',
                                message: '修改成功'
                            });
                        }
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
    .el-upload-dragger {
        width: auto;
        height: auto;
    }
</style>