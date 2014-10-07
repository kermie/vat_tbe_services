<?php
/**
 * This file is part of OXID eSales VAT TBE module.
 *
 * OXID eSales PayPal module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales PayPal module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales VAT TBE module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2014
 */

/**
 * VAT TBE oxUser class
 */
class oeVATTBEOxOrder extends oeVatTbeOxOrder_parent
{
    /**
     * Validates order parameters like stock, delivery and payment
     * parameters
     *
     * @param oxbasket $oBasket basket object
     * @param oxuser   $oUser   order user
     *
     * @return null
     */
    public function validateOrder($oBasket, $oUser)
    {
        $iValidState = parent::validateOrder($oBasket, $oUser);

        if ($oUser->getTBECountryId() && ($oBasket->getTBECountryId() != $oUser->getTBECountryId())) {
            $iValidState = oxOrder::ORDER_STATE_INVALIDDElADDRESSCHANGED;
        }

        return $iValidState;
    }
}