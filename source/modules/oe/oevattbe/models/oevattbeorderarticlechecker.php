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
 * VAT TBE order articles checker class
 */
class oeVATTBEOrderArticleChecker
{

    /** @var array|oxArticleList */
    private $_mArticleList = null;

    /** @var array List of incorrect TBE articles */
    private $_aIncorrectArticles = array();

    /**
     * Handles dependencies.
     *
     * @param array|oxArticleList $mArticleList Articles list to check.
     */
    public function __construct($mArticleList)
    {
        $this->_mArticleList = $mArticleList;
    }

    /**
     * Checks if all articles are valid.
     * Article is considered invalid if it is a TBE article and
     * article's VAT can not be calculated for user's country.
     *
     * @return bool
     */
    public function isValid()
    {
        $mArticleList = $this->_getArticleList();

        foreach ($mArticleList as $oArticle) {
            /** @var oeVATTBEOxArticle $oArticle */
            if ($oArticle->isTBEService() && is_null($oArticle->getTBEVat())) {
                $this->_aIncorrectArticles[] = $oArticle;
            }
        }

        return empty($this->_aIncorrectArticles);
    }

    /**
     * Returns list of invalid articles.
     * Article is considered invalid if it is a TBE article and
     * article's VAT can not be calculated for user's country.
     *
     * @return array
     */
    public function getInvalidArticles()
    {
        return $this->_aIncorrectArticles;
    }

    /**
     * Returns articles to work with.
     *
     * @return array|oxArticleList
     */
    protected function _getArticleList()
    {
        return $this->_mArticleList;
    }
}