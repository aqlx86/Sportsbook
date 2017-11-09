<?php

namespace SportsBook;

use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * @todo should implement own get_microsecond()
 * @todo should implement Logger
 */
class SportsBook
{
    const METHOD_DO_SETTLEMENT = 'DoSettlement';
    const METHOD_CONFIRM_BET = 'ConfirmBet';
    const METHOD_PUSH_EVENTS_INFO = 'PushEventsInfo';
    const METHOD_PLACE_BET = 'PlaceBet';
    const METHOD_GET_CUSTOMER_INFO = 'getCustomerInfo';

    public $wrap_form_data = true;

    private $http_client;

    protected $response;
    protected $headers = [];
    protected $default_params;
    protected $form_params = [];
    protected $data = null;

    public function __construct()
    {
        $this->http_client = new Client([
            'base_uri' => env('SPORTSBOOK_BASE_URI'),
            'timeout'  => 10.0,
        ]);

        $this->default_params = [
            'Vendor'     => env('SPORTSBOOK_VENDOR'),
            'VendorKey'  => env('SPORTSBOOK_VENDOR_KEY'),
            'TimeStamp'  => Carbon::now()->format('Y/m/d H:i:s.u').get_microsecond(),
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
        \Log::info($this->form_params);
        \Log::info($this->headers);
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

    protected function prepare_params()
    {
        if ($this->data)
            $this->form_params['Data'] = $this->data;

        $this->form_params = array_merge($this->default_params, $this->form_params);
    }

}