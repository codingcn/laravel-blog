<template>
    <div class="login-wrap">
        <div class="ms-title">后台管理系统</div>
        <div class="ms-login">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="0px" class="demo-ruleForm">
                <el-form-item prop="username">
                    <el-input v-model="ruleForm.username" placeholder="username"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input type="password" placeholder="password" v-model="ruleForm.password"
                              @keyup.enter.native="submitForm('ruleForm')"></el-input>
                </el-form-item>
                <div class="login-btn">
                    <el-button type="primary" :loading="loading" @click="submitForm('ruleForm')">登录</el-button>
                </div>
                <p style="font-size:12px;line-height:30px;color:#999;">Tips : 用户名和密码随便填。</p>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                loading: false,
                ruleForm: {
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        {required: true, message: '请输入用户名', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请输入密码', trigger: 'blur'}
                    ]
                }
            }
        },
        methods: {
            submitForm(formName) {
                const self = this;
                self.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true
                        const data = {
                            username: self.ruleForm.username,
                            password: self.ruleForm.password,
                            grant_type: 'password',
                            scopes: []
                        };

                        this.$axios({
                            url: this.$difines.root_url + '/api/oauth/token',
                            method: 'post',
                            data:data
                        }).then(response => {
                                // 刚开始踩坑了，js的时间戳微妙为单位，而且木有时区，和PHP不一样
                                let js_time = Math.round(new Date().getTime() / 1000 - 28800)
                                this.$auth.setToken(response.data.access_token, response.data.refresh_token, response.data.expires_in + js_time);
                                this.getAdmin()
                            })
                            .catch(err => {
                                this.loading = false
                                if (err.status !== 401) {
                                    this.$notify.error({
                                        title: '错误',
                                        message: '服务器开小差了'
                                    });
                                }
                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getAdmin() {
                const self = this;
                this.$axios({
                    url: this.$difines.root_url + '/api/admin/admin-user',
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + this.$auth.getToken(),
                    }
                }).then(response => {
                    localStorage.setItem('admin_user', JSON.stringify(response.data.data))
                    this.$notify({
                        title: '成功',
                        message: '登陆成功',
                        type: 'success',
                        offset: 60
                    });
                    self.$router.push('/');
                }).catch(response => {
                });
            }
        }
    }
</script>

<style scoped>
    .login-wrap {
        background-color: #324157;
        position: relative;
        width: 100%;
        height: 100%;
    }

    .ms-title {
        position: absolute;
        top: 50%;
        width: 100%;
        margin-top: -230px;
        text-align: center;
        font-size: 30px;
        color: #fff;
    }

    .ms-login {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 300px;
        height: 160px;
        margin: -150px 0 0 -190px;
        padding: 40px;
        border-radius: 5px;
        background: #fff;
    }

    .login-btn {
        text-align: center;
    }

    .login-btn button {
        width: 100%;
        height: 36px;
    }
</style>