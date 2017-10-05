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
/**
 * Ignite\Inventory\Entities\ShopItems
 *
 * @property int $id
 * @property string $name
 * @property string|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\ShopItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\ShopItems whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\ShopItems wherePrice($value)
 * @mixin \Eloquent
 */
class ShopItems extends Model
{
    protected $fillable = [];
    public $table = 'shop_items';
}
?>

