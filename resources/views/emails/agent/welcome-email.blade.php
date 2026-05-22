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

        .button-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            /* optional spacing */
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            color: #28a745;
            /* Bootstrap's success green */
            border: 2px solid #28a745;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #28a745;
            color: #ffffff;
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
                                <img alt="LogoIpsum" src="{{ asset('assets/admin/images/logo.png') }}" style="border: 0; display: block; outline: none; text-decoration: none; height: auto; width: 60%; font-size: 13px;" width="180" />
                            </td>
                        </tr>

                        <!-- Title -->
                        <tr>
                            <td align="center" valign="top" colspan="2" style="border-bottom: 1px solid #CCCCCC; padding: 20px 0 10px 0;">
                                <span style="font-size: 18px; font-weight: normal;">Welcome to Kulvriksh CRM Admin Panel</span>
                            </td>
                        </tr>

                        <!-- Messages -->
                        <tr>
                            <td align="left" valign="top" colspan="2" style="padding-top: 10px;">
                                <span style="font-size: 12px; line-height: 1.5; color: #333333;">
                                    Dear {{ $agent->roles->pluck('name')->first() }},
                                    <br /><br />
                                    <p>Your administrator account for <strong>Kulvriksh CRM</strong> has been successfully created.</p>
                                    <p>Here are your login details:</p>
                                    <div style="text-align: left; margin-top: 20px;">
                                        <ul>
                                            <li><strong>Admin Panel URL:</strong> <a href="https://kulvriksh.simplecrm365.com/login">https://kulvriksh.simplecrm365.com/login</a></li>
                                            <li><strong>Name:</strong> {{ $agent->name }},</li>
                                            <li><strong>Email Address:</strong> {{ $agent->email }},</li>
                                            <li><strong>Password:</strong> {{ $plainPassword }}</li>
                                        </ul>
                                    </div>
                                    <br /><br />
                                    To access the Kulvriksh CRM Admin Panel, please click the button below:
                                    <br /><br />
                                    <div class="button-wrapper">
                                        <a href="https://kulvriksh.simplecrm365.com/login" class="btn">Login to Admin Panel</a>
                                    </div>

                                    <br /><br />
                                    From Kulvriksh
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
