<?php

namespace Ignite\Inventory\Library;

use Ignite\Inventory\Entities\InternalOrderDetails;
use Carbon\Carbon;
class OrderTrail
{
    protected $detail;

    public function __construct(InternalOrderDetails $detail)
    {
        $this->detail = $detail;
    }

    public function trail()
    {
        $receivedGoods = $this->getReceivedGoods();

        $dispatched = $this->getDispatched()->toArray();

        $trail = collect(array_merge($dispatched, $receivedGoods))->sortBy('date');

        return $trail;

    }

    public function getDispatched()
    {
        return $this->detail->dispatch->transform(function($dispatch){

            $facilitator = $dispatch->dispatcher->profile->fullName;

            return [
                'date' => Carbon::parse($dispatch->updated_at)->format('M d, Y h:i:s a'),

                'message' => "dispatched by ${facilitator}",

                'quantity' => $dispatch->dispatched,
            ];

        });
    }

    public function getReceivedGoods()
    {
        $received = [];

        foreach ($this->detail->received as $item)
        {
            $facilitator = $item->receiver->profile->fullName;

            if ($item->received > 0) {
                array_push($received, [
                    'date' =>  Carbon::parse($item->updated_at)->format('M d, Y h:i:s a'),

                    'message' => "received by ${facilitator}",

                    'quantity' => $item->received,
                ]);
            }

            if ($item->rejected > 0) {
                array_push($received, [
                    'date' => Carbon::parse($item->updated_at)->format('M d, Y h:i:s a'),

                    'message' => "rejected by ${facilitator}, reason - $item->reason",

                    'quantity' => $item->rejected,
                ]);
            }
        }

        return $received;
    }
}