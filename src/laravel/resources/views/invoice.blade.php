<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
    body {
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        font-size: 16px;
        line-height: 24px;
        background: #fff;
        color: #555;
    }
    
    .invoice-box {
        padding-top:30px;
    }

    table {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
    }
    
    table td {
        padding: 5px;
        vertical-align: top;
    }
    
    table tr.top table td {
        padding-bottom: 20px;
    }
    
    table tr.top table td.title {
        font-size: 35px;
        line-height: 35px;
        color: #333;
    }
    
    table tr.information table td {
        padding-bottom: 40px;
    }
    
    table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    table tr.details td {
        padding-bottom: 20px;
    }
    
    table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    table tr.item.last td {
        border-bottom: none;
    }
    
    table tr.total td {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                {{ $vendor }}
                            </td>
                            
                            <td style="text-align: right;">
                                Invoice #: {{ $id or $invoice->id }}<br>
                                Created: {{ $invoice->date() }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            @if (!empty($companyAddress)) 
                <tr class="information">
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    @foreach ($companyAddress as $addressKey => $addressVal)
                                        @if ($addressKey == 'url')
                                            <a href="{{ $addressVal }}">{{ $addressVal }}</a><br>
                                        @else
                                            {{ $addressVal }}<br>
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align: right;">
                                    {{ $user->name }}<br>
                                    {{ $user->email }}<br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endif

            <tr class="heading">
                <td>Description</td>
                <td style="text-align: right;">Date</td>
                <td style="text-align: right;">Amount</td>
            </tr>

            <!-- Existing Balance -->
            <tr class="item">
                <td>Starting Balance</td>
                <td>&nbsp;</td>
                <td style="text-align: right;">{{ $invoice->startingBalance() }}</td>
            </tr>

            <!-- Display The Invoice Items -->
            @foreach ($invoice->invoiceItems() as $item)
                <tr class="item">
                    <td colspan="2">{{ $item->description }}</td>
                    <td style="text-align: right;">{{ $item->total() }}</td>
                </tr>
            @endforeach

            <!-- Display The Subscriptions -->
            @foreach ($invoice->subscriptions() as $subscription)
                <tr class="item">
                    <td>Subscription ({{ $subscription->quantity }})</td>
                    <td style="text-align: right;">
                        {{ $subscription->startDateAsCarbon()->formatLocalized('%B %e, %Y') }} -
                        {{ $subscription->endDateAsCarbon()->formatLocalized('%B %e, %Y') }}
                    </td>
                    <td style="text-align: right;">{{ $subscription->total() }}</td>
                </tr>
            @endforeach

            <!-- Display The Discount -->
            @if ($invoice->hasDiscount())
                <tr class="item">
                    @if ($invoice->discountIsPercentage())
                        <td>{{ $invoice->coupon() }} ({{ $invoice->percentOff() }}% Off)</td>
                    @else
                        <td>{{ $invoice->coupon() }} ({{ $invoice->amountOff() }} Off)</td>
                    @endif
                    <td>&nbsp;</td>
                    <td style="text-align: right;">-{{ $invoice->discount() }}</td>
                </tr>
            @endif

            <!-- Display The Tax Amount -->
            @if ($invoice->tax_percent)
                <tr class="item">
                    <td>Tax ({{ $invoice->tax_percent }}%)</td>
                    <td>&nbsp;</td>
                    <td style="text-align: right;">{{ Laravel\Cashier\Cashier::formatAmount($invoice->tax) }}</td>
                </tr>
            @endif

            <!-- Display The Final Total -->
            <tr class="total">
                <td>&nbsp;</td>
                <td style="text-align: right;">Total</td>
                <td style="text-align: right;">{{ $invoice->total() }}</td>
            </tr>
        </table>
    </div>
</body>
</html>