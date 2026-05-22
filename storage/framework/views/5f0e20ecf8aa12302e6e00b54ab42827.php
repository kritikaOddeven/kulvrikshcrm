<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kulvriksh</title>

    <style>
        body {
            background-color: #FFFFFF;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body style="word-spacing: normal; background-color: #fafafa">

    <div style="max-width: 650px; background-color:#FFFFFF; margin: 100px auto 0 auto;">
        <table border="0" cellpadding="0" cellspacing="10" height="50%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="emailContainer" style="font-family:Arial; color: #333333;">

                        <!-- Logo -->
                        <tr>
                            <td align="center" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding-bottom: 10px;">
                                <img alt="LogoIpsum" src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" style="border: 0; display: block; outline: none; text-decoration: none; height: auto; width: 60%; font-size: 13px;" width="180" />
                            </td>
                        </tr>

                        <!-- Title -->
                        <tr>
                            <td align="center" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                <span style="font-size: 18px; font-weight: normal;">FORGOT PASSWORD</span>
                            </td>
                        </tr>

                        <!-- Messages -->
                        <tr>
                            <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                    We have sent you this email in response to your request to reset your password. After you reset your password, you will be able to login with your new password.
                                    <br /><br />
                                    To reset your password, please use the token below:
                                    <div style="text-align: center; margin-top: 20px;">
                                        <a href="<?php echo e(url('reset-password/'.$token)); ?>" style="text-decoration: none;">
                                            <h3 style="font-weight: 1000; margin: 0;">Reset Password</h3>
                                        </a>
                                    </div>
                                    <br /><br />
                                    We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your app, My Account Page and clicking on the "Change Email Address or Password" link.
                                    <br /><br />
                                    If you need help, or you have any other questions, feel free to email us.
                                    <br /><br />
                                    From Customer Service
                                </span>
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
    </div>

</body>

</html>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/emails/auth/password-reset-web.blade.php ENDPATH**/ ?>