<?php
/**
 * Created by PhpStorm.
 * User: bravoh
 * Date: 9/27/17
 * Time: 10:27 AM
 */

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

#Temporary model to import shop items with their prices
class ShopItems extends Model
{
    protected $fillable = [];
    public $table = 'shop_items';
}
?>

