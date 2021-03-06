<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
  public function __construct()
  {
  }

  public function index(Request $request)
  {
    $msg = '<ul>';
    $keyList = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($keyList as $key) {
      if (array_key_exists($key, $_SERVER)) {
        $msg .= '<li style="font-family: monospace">' . $key . ': <strong>' . $_SERVER[$key] . "</strong></li>";
      }
    }
    $msg .= '</ul>';

    //$ip = \Request::ip();
    $ip = request()->ip();
    //$ip = $this->getIp();

    return view('test-ip', [
      'msg' => $msg,
      'ip' => $ip,
    ]);
  }

  public function getIp()
  {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
      if (array_key_exists($key, $_SERVER) === true) {
        foreach (explode(',', $_SERVER[$key]) as $ip) {
          $ip = trim($ip); // just to be safe
          if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
            return $ip;
          }
        }
      }
    }
    return request()->ip(); // it will return server ip when no client ip found
  }
}
