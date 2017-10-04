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

    public function set_stock_value();

    public function updateProdPrice();
}
