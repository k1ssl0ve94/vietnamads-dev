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
                    You have been assigned to handle ticket #{{ $issue->id }}
                </div>
                <div style="padding:10px 15px;box-sizing: border-box;">
                    <p>Dear Mr/Ms {{ isset($name) ? $name : 'Friend' }},<br>
                    <strong>you have been assigned to handle ticket #{{ $issue->id }}</strong></p>
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
                            @if ($issue->assignee)
                            <ul>
                                <li>Name: {{ $issue->assignee->name }}</li>
                                <li>Phone: {{ $issue->assignee->phone }}</li>
                                <li>Email: {{ $issue->assignee->email }}</li>
                            </ul>
                            @endif
                        </td>
                    </tr>
                </table>
                <div style="padding:10px 15px;box-sizing: border-box;">
                    <p>Please handle this as soon as you can.</p>
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
