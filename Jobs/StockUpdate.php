<?php

namespace Ignite\Inventory\Jobs;

use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Library\InventoryFunctions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockUpdate  implements ShouldQueue {

    use InteractsWithQueue,
        SerializesModels;

    /**
     * @var InventoryPurchaseOrders
     */
    protected $batch;
    protected $direct;

    /**
     * Create a new job instance.
     *
     * @param InventoryBatch $batch
     */
    public function __construct(InventoryBatch $batch, $direct = false) {
        $this->batch = $batch;
        $this->direct = $direct;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        return InventoryFunctions::update_stock_from_lpo($this->batch, $this->direct);
    }

}
