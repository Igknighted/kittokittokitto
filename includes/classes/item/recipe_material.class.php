<?php
/**
 * Recipe materials definition. 
 *
 * This file is part of 'Kitto_Kitto_Kitto'.
 *
 * 'Kitto_Kitto_Kitto' is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 3 of the License,
 * or (at your option) any later version.
 * 
 * 'Kitto_Kitto_Kitto' is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU General
 * Public License along with 'Kitto_Kitto_Kitto'; if not,
 * write to the Free Software Foundation, Inc., 51
 * Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @author Nicholas 'Owl' Evans <owlmanatt@gmail.com>
 * @copyright Nicolas Evans, 2009
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3
 * @package Kitto_Kitto_Kitto
 * @subpackage Items
 * @version 1.0.0
 **/

/**
 * Recipe ingredients.
 * 
 * @uses ActiveTable
 * @package Kitto_Kitto_Kitto
 * @subpackage Items 
 * @copyright 2009 Nicholas Evans
 * @author Nick 'Owl' Evans <owlmanatt@gmail> 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPL v3
 **/
class RecipeMaterial extends ActiveTable
{
    protected $table_name = 'item_recipe_material';
    protected $primary_key = 'item_recipe_material_id';
    protected $RELATED = array(
        'recipe' => array(
            'class' => 'Recipe_Item',
            'local_key' => 'recipe_item_type_id',
            'foreign_key' => 'item_type_id',
            'one' => true,
        ),
        'material' => array(
            'class' => 'ItemType',
            'local_key' => 'material_item_type_id',
            'foreign_key' => 'item_type_id',
            'one' => true,
        ),
    );

} // end RecipeMaterial

?>
