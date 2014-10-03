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
 * @copyright (C) OXID eSales AG 2003-2014T
 */

/**
 * Test class for oeVATTBEEvidenceCalculator.
 *
 * @covers oeVATTBEEvidenceList
 */
class Unit_oeVATTBE_Models_Evidences_oeVATTBEEvidenceListTest extends OxidTestCase
{
    public function testAddingToList()
    {
        $oEvidence = $this->getMock('oeVATTBEEvidence');

        $oList = new oeVATTBEEvidenceList();
        $oList->add($oEvidence);

        $aElements = array();
        foreach ($oList as $iItem) {
            $aElements[] = $iItem;
        }

        $this->assertEquals(array($oEvidence), $aElements);
    }

    public function testAddingToListWhenNonEvidenceIsAdded()
    {
        $oList = new oeVATTBEEvidenceList();

        $this->setExpectedException('Exception');

        $oList->add(1);
    }
}