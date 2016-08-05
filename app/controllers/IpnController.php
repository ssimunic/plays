<?php

class IpnController extends BaseController {

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function store() {
        
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        // post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);
        if (!$fp) {
            // HTTP ERROR
        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp($res, "VERIFIED") == 0) {
                    $currency_code = 'USD';

                    if($_POST['mc_gross'] == 2.99 || $_POST['mc_gross'] == 24.99)
                    {
                        //
                    }
                    else
                    {
                        return false;
                    }
                    
                    $payment = new Payment();
                    $payment->amount = round($_POST['mc_gross'], 0);
                    $payment->type = $_POST['txn_id'];
                    $payment->date = Server::getDate();
                    $payment->p_email = $_POST['payer_email'];
                    
                    $user = User::where('email', '=', $_POST['payer_email'])->first();
                    if($_POST['mc_gross'] == 2.99)
                    {
                        $span = 30;
                    }
                    if($_POST['mc_gross'] == 24.99)
                    {
                        $span = 365;
                    }
                    $time = date('Y-m-d H:i:s',time()+86400*$span);
                    $user->user_type_id = 2;
                    $user->premium_till = $time;
                    $user->save();
					
                    if($user)
					{
						$payment->user_id = $user->id;
					}
					else
					{
						$payment->user_id = '1';
					}
					
                    $payment->save();
                    
                } else if (strcmp($res, "INVALID") == 0) {

                    // PAYMENT INVALID
                }
            }
            fclose($fp);
        }
    }

}
