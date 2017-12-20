<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Repositories;

/**
 * Interface InventoryRepository
 * @package Ignite\Inventory\Repositories
 */
interface InventoryRepository
{
    /**
     * @param int|null $id
     * @return mixed
     */
    public function add_product($id = null);

    /**
     * @return mixed
     */
    public function set_stock_value();

    /**
     * @return mixed
     */
    public function updateProdPrice();

    /**
     * @param int|null $id
     * @return mixed
     */
    public function record_sales($id = null);

    /**
     * @param bool $true
     * @return mixed
     */
    public function getSales($true = false);

    public function saveInternalOrder();
}
