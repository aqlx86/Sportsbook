<?php

namespace SportsBook;

use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * @todo log requests
 */
class SportsBook
{
    const METHOD_DO_SETTLEMENT = 'DoSettlement';
    const METHOD_CONFIRM_BET = 'ConfirmBet';
    const METHOD_PUSH_EVENTS_INFO = 'PushEventsInfo';
    const METHOD_PLACE_BET = 'PlaceBet';
    const METHOD_GET_CUSTOMER_INFO = 'getCustomerInfo';
    const METHOD_GET_BALANCE = 'GetBalance';

    public $wrap_form_data = true;

    private $http_client;

    protected $response;
    protected $headers = [];
    protected $default_params;
    protected $form_params = [];
    protected $data = null;

    public function __construct()
    {
        $config = config('sportsbook');

        $this->http_client = new Client([
            'base_uri' => $config['api_url'],
            'timeout'  => 10.0,
        ]);

        $this->default_params = [
            'Vendor'     => env('SPORTSBOOK_VENDOR'),
            'VendorKey'  => env('SPORTSBOOK_VENDOR_KEY'),
            'TimeStamp'  => Carbon::now()->format('Y/m/d H:i:s').'.'.get_microsecond(),
            'Seq'        => str_random(16).time(),
        ];
    }

    public function set_data(array $data)
    {
        $this->data = $data;
    }

    public function append_form_params(array $params)
    {
        $this->form_params = array_merge($this->form_params, $params);
    }

    public function add_param($key, $value)
    {
        $this->form_params[$key] = $value;
    }

    public function add_header($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function post($method)
    {
        $this->prepare_params();

        $this->response = $this->http_client->request('POST', $method, [
            'json' => $this->form_params,
            'headers' => $this->headers,
        ]);

        return $this;
    }

    public function response()
    {
        return json_decode($this->response->getBody(), true);
    }

    public function has_error()
    {
        return (bool) $this->response()['ErrorCode'];
    }

    public function get_error()
    {
        return [
            'code' => $this->response()['ErrorCode'],
            'message' => $this->response()['ErrorMsg']
        ];
    }

    protected function prepare_params()
    {
        if ($this->data)
            $this->form_params['Data'] = $this->data;

        $this->form_params = array_merge($this->default_params, $this->form_params);
    }

}