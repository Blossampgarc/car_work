<?php
$order = App\Models\orders::get_order($details['order_id']);
$order_detail = $order->get_order_details($order->id); $user = $order->get_user($order->user_id); ?>
<html>
    <body style="background-color: #e2e1e0; font-family: Open Sans, sans-serif; font-size: 100%; font-weight: 400; line-height: 1.4; color: #000;">
        <table
            style="
                max-width: 670px;
                margin: 50px auto 10px;
                background-color: #fff;
                padding: 50px;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                border-top: solid 10px green;
            "
        >
            <thead>
                <tr>
                    <th style="text-align: left;"><img style="max-width: 150px;" src="<?php echo(asset('web/images/logo.png')) ?>" /></th>

                    <th style="text-align: right; font-weight: 400;">{{ $details['message']}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 35px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: solid 1px #ddd; padding: 10px 20px;">
                        <p style="font-size: 14px; margin: 0 0 0 0;"><span style="font-weight: bold; display: inline-block; min-width: 146px;">Order amount</span>${{ $order->amount_total }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 35px;"></td>
                </tr>
                <tr>
                    <td style="width: 50%; padding: 20px; vertical-align: top;">
                        <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;"><span style="display: block; font-weight: bold; font-size: 13px;">Name</span> {{$user->name}}</p>
                        <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;"><span style="display: block; font-weight: bold; font-size: 13px;">Email</span> {{$user->email}}</p>
                    </td>
                    <td style="width: 50%; padding: 20px; vertical-align: top;">
                        <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;"><span style="display: block; font-weight: bold; font-size: 13px;">Address</span> {{$order->address}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 20px; padding: 30px 15px 0 15px;">Items</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 15px;">
                        @foreach ($order_detail as $ord) @php $product = $order->get_product($ord->product_id); @endphp
                        <p style="font-size: 12px; margin: 0; padding: 10px; border: solid 1px #ddd; font-weight: 300;">
                            <span style="display: block; font-size: 13px; font-weight: normal;">{{$product->model}}</span> ${{$ord->price}}({{$ord->qty}}) <b style="font-size: 14px; font-weight: bold;"> - ${{$ord->amount}}</b>
                        </p>
                        @endforeach
                    </td>
                </tr>
            </tbody>
            <tfooter>
                <tr>
                    <td colspan="2" style="font-size: 14px; padding: 50px 15px 0 15px;"><strong style="display: block; margin: 0 0 10px 0;">Regards</strong> Smart Auto Parts<br /></td>
                </tr>
            </tfooter>
        </table>
    </body>
</html>
