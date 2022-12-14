<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('messages.purchase_order')}}</title>
    <style>
        @page {
             margin: 0px;
             padding:0px;
             font-size:15px;
        }
        body{
            margin:0;
            padding:20px;
            padding-top:210px;
            padding-bottom:100px;
            font-family: Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif;
            background-image:url("{{public_path('assets/images/background-pdf.png')}}");
            background-size:100% 100%;
        }
        .header{
            position:fixed;
            width:100%;
            top:0;
            left:0;
        }
        .img-header-logo{
            height:100px;
        }
        .div-header-logo{
            padding:20px;
        }
        .div-header-title{
            width:100%;
            background:#e5b407;
            text-align:right;
            height:40px;
            padding:0;
            position:relative;
        }
        .header-title{
            position:absolute;
            background:white;
            color:black;
            width:fit-content;
            font-weight:bold;
            margin-right: 50px;
            font-size:32px;
            padding:0px;
            margin-top:1px;
            right:0;
            padding:0px 20px;
        }
        .span-series{
            color:#e5b407;
        }
        .footer{
            position:fixed;
            width:100%;
            bottom:0;
            left:0;
            padding:20px;
            background:#e5b407;
            color:white;
        }
        .div-footer-number-page{
            text-align:center;
            font-weight:bold;
        }
        .footer-number-page::after{
            content: counter(page);
        }
        .div-information-purchase_order{
            padding:10px;
        }
        .p-0{
            padding:0px !important;
        }
        .m-0{
            margin:0px !important;
        }
        .text-verticaly-top{
            vertical-align: top;
        }
        .div-table{
            padding:20px;
        }
        .table-sale-invoice{
            width:100%;
            border-collapse: collapse;
        }
        .table-sale-invoice thead tr th{
            padding:10px;
            background:black;
            color:white
        }
        .table-sale-invoice tbody tr td,.table-sale-invoice tfoot tr td{
            padding:10px;
        }
        .text-gray{
            color:gray;
        }
        .text-white{
            color:white !important;
        }
        .bg-black{
            background:black !important;
        }
        .text-center{
            text-align:center !important;
        }
        .text-right{
            text-align:right !important;
        }
        .text-left{
            text-align:left !important;
        }
        .div-signature{
            margin-right:100px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="div-header-logo">
            <img src="{{auth()->user()->logo ? public_path(auth()->user()->logo) : public_path('assets/images/logo-pdf.png')}}" onerror="this.onerror=null;this.src=`{{public_path('assets/images/default-image.png')}}`" alt="" class="img-header-logo">
        </div>
        <div class="div-header-title">
        <span class="header-title">{{__('messages.purchase_order')}} : <span class="span-series">N?? {{$purchase_order->series}}</span></span>
        </div>
    </header>
    <footer class="footer">
        <div class="div-administrator-information">
            <table width="100%">
                <tbody>
                    <tr>
                        <td><span><b>{{__('messages.address')}} :</b> {{auth()->user()->address}}</span></td>
                        <td><span><b>{{__('messages.email')}} :</b> {{auth()->user()->email}}</span></td>
                        <td><span><b>{{__('messages.phone')}} :</b> {{auth()->user()->phone}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="div-footer-number-page">
            <span class="footer-number-page"></span>
        </div>
    </footer>
    <main>
        <div class="div-information-purchase_order">
            <table width="100%">
                <tbody>
                    <tr>
                        <td width="50%">
                            <div><h3 class="m-0">{{__('messages.purchase_order_to')}} :</h3></div>
                            <br>
                            <div><b>{{__('messages.fullname')}} : {{$purchase_order->supplier->fullname}}</b></div>
                            <div><b>{{__('messages.email')}} : </b>{{$purchase_order->supplier->email}}</div>
                            <div><b>{{__('messages.address')}} : </b>{{$purchase_order->supplier->address}}</div>
                            <div><b>{{__('messages.phone')}} : </b>{{$purchase_order->supplier->phone}}</div>
                        </td>
                        <td width="15%" class="text-verticaly-top">
                            <div><div><b>{{__('messages.date')}} : </b>{{\Carbon\Carbon::parse($purchase_order->start_date)->format('d/m/Y')}}</div></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="div-table">
            {!!$purchase_order->note!!}
        </div>
        <div class="div-signature">
            <p class="text-right"><b><u>Signature</u></b></p>
        </div>  
    </main>
</body>
</html>