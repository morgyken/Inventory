<?php
/**
 * Created by PhpStorm.
 * User: kisiara
 * Date: 13/01/2018
 * Time: 16:09
 */

namespace Ignite\Inventory\Repositories;

use Auth;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\InternalOrderDetails;
use Ignite\Inventory\Entities\InternalOrderDispatch;

class DispatchesRepository
{
    public function dispatchInternal()
    {
        $to_dispatch = request('dispatch');
        $order_id = request('order_id');
        $order = InternalOrder::find($order_id);

        \DB::beginTransaction();
        try {
            foreach ($to_dispatch as $k => $v) {
                $item = InternalOrderDetails::find($k);
                $_needed = $item->quantity - $item->dispatched;
                if ($v > $_needed) {
                    flash('Cannot dispatch more than requested', 'danger');
                    throw new \Exception('Cannot dispatch more than requested');
                }
                InternalOrderDispatch::create([
                    'item_id' => $item->id,
                    'qty_dispatched' => $v,
                    'dispatch_user' => Auth::user()->id,
                ]);
            }
            $this->recordStatus($order);
        } catch (\Exception $e) {
            return \DB::rollBack();
        }
        \DB::commit();

        return $order;
    }

    /**
     * @param InternalOrder $order
     * @return bool
     */
    private function recordStatus(InternalOrder $order): bool
    {
        $to_dispatch = $order->details->sum('pending');
        $order->status = empty($to_dispatch) ? 2 : 1;
        return $order->save();
    }
}