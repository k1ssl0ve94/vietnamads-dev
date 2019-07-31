<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
    </style>
</head>
<body style="background-color:#fff;font-family:Arial, Helvetica, sans-serif;font-size:14px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;background-color:#eee;margin-top:30px;" align="center">
        <tr>
            <td>
                <div style="width:100%;background-color:#c79848;padding:20px;color:#fff;box-sizing: border-box;text-align:center;font-size:18px;font-weight:bold">
                    Your order is being processed #{abc}
                </div>
                <div style="padding:10px 15px;box-sizing: border-box;">
                    <p>Dear Mr/Ms {{ isset($name) ? $name : 'Friend' }},<br>
                    <strong>Your order is being processed</strong></p>
                </div>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;" align="center" bordercolor="#c79848">
                    <tr>
                        <td style="padding:10px 5px;background-color:#c79848;color:#fff">
                            Ticket's Info
                        </td>
                        <td style="padding:10px 5px;background-color:#c79848;color:#fff">
                            Handler
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px" width="50%">
                            <ul>
                                <li>ID: {{ $issue->id }}</li>
                                <li>Title: {{ $issue->title }}</li>
                            </ul>
                        </td>
                        <td style="padding:10px" width="50%">
                            <ul>
                                <li>Name: {{ 'name' }}</li>
                                <li>Phone: {{ 'phone' }}</li>
                                <li>Email: {{ 'email' }}</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <div style="padding:10px 15px;box-sizing: border-box;">
                    <p>
                        All the best.
                        <br> --- TMS Team.
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
