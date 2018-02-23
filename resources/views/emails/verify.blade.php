<table border="0" cellpadding="0" cellspacing="0" width="100%"
       style="border-collapse: collapse;background-color: #ebedf0;font-family:'Alright Sans LP', 'Avenir Next', 'Helvetica Neue', Helvetica, Arial, 'PingFang SC', 'Source Han Sans SC', 'Hiragino Sans GB', 'Microsoft YaHei', 'WenQuanYi MicroHei', sans-serif;">
    <tbody>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" align="center" width="640">
                <tbody>
                <tr>
                    <td style="height:20px;"></td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                            <tr style="line-height: 40px;">
                                <td style="font-size: 24px;color:#292c33;">【{{getSetting('site_title')}}】账号注册邮箱确认</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="40"></td>
                </tr>
                <tr>
                    <td style="background-color: #fff;border-radius:6px;padding:40px 40px 0;">
                        <table>
                            <tbody>
                            <tr height="40">
                                <td style="padding-left:25px;padding-right:25px;font-size:14px;font-family:'微软雅黑','黑体',arial;color:#525866;">
                                    尊敬的{{getSetting('site_title')}}用户，您好:
                                </td>
                            </tr>
                            <tr height="15">
                                <td></td>
                            </tr>
                            <tr height="30">
                                <td style="padding-left:25px;padding-right:25px;text-indent:2em;font-size:14px;line-height:24px;font-family:'微软雅黑','黑体',arial;color:#525866;">
                                    您的账号 <strong> <a href="mailto:{{$verify->email}}"
                                                     target="_blank">{{$verify->email}}</a>
                                    </strong> 正在<a href="{{url('')}}">{{getSetting('site_title')}}</a>进行账号注册。
                                </td>
                            </tr>
                            <tr height="10">
                                <td></td>
                            </tr>
                            <tr height="30">
                                <td style="padding-left:25px;padding-right:25px;text-indent:2em;font-size:14px;line-height:24px;font-family:'微软雅黑','黑体',arial;color:#525866;">
                                    为保证您的服务正常使用，请您尽快激活邮箱。如不是本人操作请忽略。
                                </td>
                            </tr>
                            <tr height="15">
                                <td></td>
                            </tr>
                            <tr height="15">
                                <td style="padding-left:25px;padding-right:25px;text-indent:2em;font-size:16px;line-height:28px;font-family:'微软雅黑','黑体',arial;color: #000;">
                                    点击链接激活并登陆： <a
                                            href="{{url('/email/verify',$verify->token)}}">{{url('/email/verify',$verify->token)}}</a>
                                </td>
                            </tr>
                            <tr height="15">
                                <td></td>
                            </tr>
                            <tr height="10">
                                <td></td>
                            </tr>
                            <tr height="30">
                                <td style="padding-left:25px;padding-right:25px;font-size:14px;line-height:24px;font-family:'微软雅黑','黑体',arial;color:#525866;">
                                    谢谢！
                                </td>
                            </tr>
                            <tr height="10">
                                <td></td>
                            </tr>
                            <tr height="30">
                                <td style="padding-left:25px;padding-right:25px;text-align:right;font-size:14px;line-height:24px;font-family:'微软雅黑','黑体',arial;color:#525866;">
                                    —— {{getSetting('site_title')}}
                                </td>
                            </tr>
                            <tr height="50">
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="height:40px;"></td>
                </tr>
                <tr>
                    <td style="text-align: center;color:#7a8599;font-size: 12px;">

                        <p style="line-height: 20px;">
                            <a style="text-decoration: none;color:#7a8599;padding:0 5px;"
                               href="{{url('')}}"
                               target="_blank">首页</a> -
                            <a style="text-decoration: none;color:#7a8599;padding:0 5px;"
                               href="{{url('/about')}}"
                               target="_blank">关于</a> -
                            联系我
                            <span style="text-decoration: none;color:#7a8599;padding:0 5px;"><span
                                        style="border-bottom:1px dashed #ccc;z-index:1"> 5303221@gmail.com</span></span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="height:50px;"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>