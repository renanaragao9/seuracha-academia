<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{{ $configuration?->name ?? config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>

body {
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.wrapper {
    background-color: #f4f4f4;
    width: 100%;
}

.inner-body {
    background-color: #ffffff;
    width: 570px;
    margin: 0 auto;
}

.header-bg {
    background: linear-gradient(135deg, #10b981, #047857);
    padding: 15px 25px;
    text-align: center;
}

.footer-bg {
    background: linear-gradient(135deg, #059669, #065f46);
    padding: 30px 25px;
    text-align: center;
    color: #ffffff;
}

.verification-box {
    background-color: #e8e8e8;
    border-radius: 12px;
    padding: 30px;
    margin: 20px 0;
    text-align: center;
}

.code-text {
    font-size: 36px;
    font-weight: bold;
    color: #000000;
    letter-spacing: 2px;
}

.content-cell {
    padding: 30px 35px;
    color: #333333;
    font-size: 16px;
    line-height: 1.5;
}

.button {
    display: inline-block;
    padding: 14px 35px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 6px;
    text-align: center;
    transition: all 0.3s ease;
}

.button-primary {
    background: linear-gradient(135deg, #10b981, #047857);
    color: #ffffff !important;
}

.button-success {
    background-color: #10b981;
    color: #ffffff !important;
}

.button-secondary {
    background-color: #6c757d;
    color: #ffffff !important;
}

.button-outline {
    background-color: transparent;
    border: 2px solid #059669;
    color: #059669 !important;
}

.details-table {
    width: 100%;
    border-collapse: collapse;
    margin: 25px 0;
}

.details-table td {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.details-label {
    color: #888;
    font-size: 14px;
}

.details-value {
    text-align: right;
    font-weight: bold;
    color: #047857;
}

.details-total-label {
    padding: 15px 0;
    color: #047857;
    font-size: 16px;
    font-weight: bold;
}

.details-total-value {
    padding: 15px 0;
    text-align: right;
    font-size: 20px;
    font-weight: 800;
    color: #10b981;
}

.social-icons img {
    width: 32px;
    margin: 0 6px;
}

.links-footer a {
    color: #34d399;
    text-decoration: none;
    font-size: 12px;
    margin: 0 5px;
}

@media only screen and (max-width: 600px) {
    .inner-body {
        width: 100% !important;
    }
}

@media only screen and (max-width: 500px) {
    .button {
        width: 100% !important;
        display: block;
    }
}
</style>
{!! $head ?? '' !!}
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="inner-body" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{!! $header ?? '' !!}

<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>
</body>
</html>
