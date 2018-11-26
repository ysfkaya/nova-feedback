<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
    <title>{{ trans('nova-feedback::resources.error_report') }}</title>

    <style type="text/css">

        body {
            width: 100%;
            background-color: #383434;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }

        p, h1, h2, h3, h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        span.preheader {
            display: none;
            font-size: 1px;
        }

        html {
            width: 100%;
        }

        table {
            font-size: 12px;
            border: 0;
        }

        .menu-space {
            padding-right: 25px;
        }

        a, a:hover {
            text-decoration: none;
            color: #FFF;
        }

        @media only screen and (max-width: 640px) {
            body {
                width: auto !important;
            }

            table [class=main] {
                width: 440px !important;
            }

            table [class=two-left] {
                width: 420px !important;
                margin: 0px auto;
            }

            table [class=full] {
                width: 100% !important;
                margin: 0px auto;
            }

            table [class=two-left-inner] {
                width: 400px !important;
                margin: 0px auto;
            }

            table [class=menu-icon] {
                display: none;
            }

        }

        @media only screen and (max-width: 479px) {
            body {
                width: auto !important;
            }

            table [class=main] {
                width: 310px !important;
            }

            table [class=two-left] {
                width: 300px !important;
                margin: 0px auto;
            }

            table [class=full] {
                width: 100% !important;
                margin: 0px auto;
            }

            table [class=two-left-inner] {
                width: 280px !important;
                margin: 0px auto;
            }

            table [class=menu-icon] {
                display: none;
            }

        }


    </style>

</head>

<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!--Main Table Start-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434">
    <tr>
        <td align="center" valign="middle">


            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td height="90" align="center" valign="top" style="font-size:90px; line-height:90px;">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="center" valign="top" bgcolor="#FFFFFF"
                                    style="-moz-border-radius: 25px 25px 0px 0px; border-radius: 25px 25px 0px 0px; border-bottom:#e2e3e3 solid 1px;">
                                    <table width="380" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td height="35" align="center" valign="top"
                                                style="font-size:35px; line-height:35px;">&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center" valign="middle">
                                                            <a href="{{ env('APP_URL') }}"
                                                               style="font-size: 32px;color: black">
                                                                {{ env('SITE_NAME','Laravel') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="20" align="center" valign="top"
                                                style="font-size:20px; line-height:20px;">&nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="center" valign="top" bgcolor="#FFFFFF">
                                    <table width="380" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td height="60" align="center" valign="top"
                                                style="font-size:60px; line-height:60px;">&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="100%" border="0" align="center" cellpadding="0"
                                                       cellspacing="0">

                                                    <tr>
                                                        <td align="center" valign="top"
                                                            style="font-family:Arial, Helvetica, sans-serif; font-size:30px; color:#4c4c4c; font-weight:normal;">
                                                            {{ trans('nova-feedback::resources.error_report') }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td height="10" align="center" valign="top"
                                                            style="font-size:10px; line-height:10px;">&nbsp;
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" valign="middle" bgcolor="#f5f5f5"
                                                                        style="-moz-border-radius: 8px; border-radius: 8px; border:dashed #CCC 1px;">
                                                                        <table width="250" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0"
                                                                               style="font-size:18px">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td height="25" align="center"
                                                                                    valign="top">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>{{ trans('nova-feedback::error_reports.subject') }}
                                                                                    :
                                                                                </th>
                                                                                <td>{{ $error->subject }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="10" align="center"
                                                                                    valign="top">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>{{ trans('nova-feedback::error_reports.priority') }}
                                                                                    :
                                                                                </th>
                                                                                <td>{{ $error->priorityText() }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="25" align="center"
                                                                                    valign="top">&nbsp;
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="30" align="center" valign="middle">
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table width="155" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                <tr>
                                                                    <td height="50" align="center" valign="middle"
                                                                        bgcolor="#fe573c">
                                                                        <a href="{{ url(config('nova.path').'/errorReport/show/'.$error->id) }}"
                                                                           style="padding:15px 35px;font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#FFF; font-weight:normal; text-transform:uppercase;text-decoration:none;">
                                                                            {{ trans('nova-feedback::global.details') }}
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="50" align="center" valign="top"
                                                style="font-size:50px; line-height:50px;">&nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="center" valign="top" bgcolor="#FFFFFF"
                                    style="-moz-border-radius:0px 0px 25px 25px; border-radius:0px 0px 25px 25px;">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="center" valign="top">
                                    <table width="380" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td height="35" align="center" valign="top"
                                                style="font-size:35px; line-height:35px;">&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top"
                                                style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold; line-height:28px;">
                                                Copyright
                                                &copy; {{ date('Y') }} {!! parse_url(env('APP_URL'),PHP_URL_HOST) !!}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="middle">
                        <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td height="90" align="center" valign="top" style="font-size:90px; line-height:90px;">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


        </td>
    </tr>
</table>

<!--Main Table End-->

</body>
</html>
