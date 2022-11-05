<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('messages.report')}}</title>
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
            background:#ffc90a;
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
            color:#ffc90a;
        }
        .footer{
            position:fixed;
            width:100%;
            bottom:0;
            left:0;
            padding:20px;
            background:#ffc90a;
            color:white;
        }
        .div-footer-number-page{
            text-align:center;
            font-weight:bold;
        }
        .footer-number-page::after{
            content: counter(page);
        }
        .div-information-report{
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
        .div-title{
            width:100%;
            background:black;
            color:white;
            height:40px;
            padding:0;
            position:relative;

        }
        .div-title h3{
            padding-left:10px;
            padding-top:7px;
        }
    </style>
</head>
<body>
    @include('layouts.pdf_parcials.header',['title'=>__('messages.report')])
    @include('layouts.pdf_parcials.footer')
    <main>
        <div class="div-table">
            <div class="div-delivery-orders">
                <div class="div-title"><h3>{{__('messages.delivery_orders')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$delivery_orders_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$delivery_orders_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$delivery_orders_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$delivery_orders_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-purchase-invoices">
                <div class="div-title"><h3>{{__('messages.purchase_invoices')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$purchase_invoices_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$purchase_invoices_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$purchase_invoices_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$purchase_invoices_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-charges">
                <div class="div-title"><h3>{{__('messages.charges')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$charges_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$charges_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$charges_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-activities">
                <div class="div-title"><h3>{{__('messages.activities')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$activities_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$activities_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$activities_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$activities_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-sale-invoices">
                <div class="div-title"><h3>{{__('messages.sale_invoices')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$sale_invoices_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$sale_invoices_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$sale_invoices_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$sale_invoices_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-purchase-total">
                <div class="div-title"><h3>{{__('messages.purchase_total')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$delivery_orders_activated_payments + $purchase_invoices_activated_payments +$charges_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$delivery_orders_canceled_payments + $purchase_invoices_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$delivery_orders_unpaid_payments + $purchase_invoices_unpaid_payments + $charges_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$delivery_orders_paid_payments + $purchase_invoices_paid_payments + $charges_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-sale-total">
                <div class="div-title"><h3>{{__('messages.sale_total')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.activated')}} : </b>{{$activities_activated_payments + $sale_invoices_activated_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.canceled')}} : </b>{{$activities_canceled_payments + $sale_invoices_canceled_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.unpaid')}} : </b>{{$activities_unpaid_payments + $sale_invoices_unpaid_payments}} <b>MAD</b></p>
                </div>
                <div>
                    <p class="m-0"><b>{{__('messages.paid')}} : </b>{{$activities_paid_payments + $sale_invoices_paid_payments}} <b>MAD</b></p>
                </div>
            </div>
            <div class="div-sale-total">
                <div class="div-title"><h3>{{__('messages.earned_money')}}</h3></div>
                <div>
                    <p class="m-0"><b>{{__('messages.total')}} : </b>{{($activities_paid_payments + $sale_invoices_paid_payments) - ($delivery_orders_unpaid_payments + $purchase_invoices_unpaid_payments + $charges_unpaid_payments)}} <b>MAD</b></p>
                </div>
            </div>
        </div>  
    </main>
</body>
</html>