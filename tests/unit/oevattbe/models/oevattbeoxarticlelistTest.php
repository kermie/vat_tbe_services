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
 * Testing extended oxArticle class.
 */
class Unit_oeVATTBE_models_oeVATTBEOxArticleListTest extends OxidTestCase
{
    /**
     * Initialize the fixture.
     */
    protected function setUp()
    {
        $this->_prepareData();
    }

    /**
     * data provider
     *
     * @return array
     */
    public function userConfiguration()
    {
        return array(
            array( 'local', null ),
            array( 'notLoggedIn', null ),
            array( 'notLocal', '8.00' )
        );
    }

    /**
     * Category list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testCategoryList($sUserStatus, $sVat)
    {
        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadCategoryArticles('30e44ab8593023055.23928895', null);

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Category list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testManufacturerList($sUserStatus, $sVat)
    {
        $oArticle = oxNew('oxArticle');
        $oArticle->setId('1126');
        $oArticle->oxarticles__oxmanufacturerid = new oxField('manufacturerId');
        $oArticle->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadManufacturerArticles('manufacturerId');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Category list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testVendorList($sUserStatus, $sVat)
    {
        $oArticle = oxNew('oxArticle');
        $oArticle->setId('1126');
        $oArticle->oxarticles__oxvendorid = new oxField('vendorId');
        $oArticle->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadVendorArticles('vendorId');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Category list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testTagList($sUserStatus, $sVat)
    {
        $oArticleTagList = oxNew('oxArticleTagList');
        $oArticleTagList->setArticleId('1126');
        $oArticleTagList->set('tag');
        $oArticleTagList->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadTagArticles('tag', oxRegistry::getLang()->getBaseLanguage());

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Category list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testPriceCategoryList($sUserStatus, $sVat)
    {
        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadPriceArticles(20, 40);

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Action list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testActionList($sUserStatus, $sVat)
    {
        $oArticle2Action = oxNew('oxbase');
        $oArticle2Action->init('oxactions2article');
        $oArticle2Action->oxactions2article__oxactionid = new oxField('oxstart');
        $oArticle2Action->oxactions2article__oxartid = new oxField('1126');
        $oArticle2Action->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadActionArticles('oxstart');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Newest list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testNewestList($sUserStatus, $sVat)
    {
        $this->getConfig()->setConfigParam('iNewestArticlesMode', 2);
        $this->getConfig()->setConfigParam('blNewArtByInsert', false);

        $oArticle = oxNew('oxArticle');
        $oArticle->setId('1126');
        $oArticle->oxarticles__oxtimestamp = new oxField(date('Y-m-d H:i:s', oxRegistry::get("oxUtilsDate")->getTime()));
        $oArticle->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadNewestArticles();

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Top 5 list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testTop5Articles($sUserStatus, $sVat)
    {
        $this->getConfig()->setConfigParam('iTop5Mode', 2);

        $oArticle = oxNew('oxArticle');
        $oArticle->setId('1126');
        $oArticle->oxarticles__oxsoldamount = new oxField(9999);
        $oArticle->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadTop5Articles();

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Cross selling list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testArticleCrossSell($sUserStatus, $sVat)
    {
        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadArticleCrossSell('1964');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Article accessoires list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testArticleAccessoires($sUserStatus, $sVat)
    {
        $oAccessoire2article = oxNew("oxbase");
        $oAccessoire2article->init("oxaccessoire2article");
        $oAccessoire2article->oxaccessoire2article__oxobjectid = new oxField('1126');
        $oAccessoire2article->oxaccessoire2article__oxarticlenid = new oxField('1964');
        $oAccessoire2article->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadArticleAccessoires('1964');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * Recommendation list test case
     *
     * @param string $sUserStatus user status
     * @param string $sVat        vat value
     *
     * @dataProvider userConfiguration
     */
    public function testloadRecommArticles($sUserStatus, $sVat)
    {
        $oObject2list = oxNew("oxbase");
        $oObject2list->init("oxobject2list");
        $oObject2list->oxobject2list__oxobjectid = new oxField('1126');
        $oObject2list->oxobject2list__oxlistid = new oxField('list');
        $oObject2list->save();

        $oArticleList = $this->_getArticleList($sUserStatus);
        $oArticleList->loadRecommArticles('list');

        /** @var oxArticle $oArticle */
        $oArticle = $oArticleList['1126'];

        $this->assertSame($sVat, $oArticle->getTBEVat());
    }

    /**
     * prepare data
     *
     */
    protected function _prepareData()
    {
        $oDb = oxDb::getDb();

        $oDb->execute("TRUNCATE TABLE oevattbe_countryvatgroups");
        $oDb->execute("TRUNCATE TABLE oevattbe_articlevat");

        $sql = "INSERT INTO oevattbe_countryvatgroups SET OEVATTBE_ID = 1, OEVATTBE_COUNTRYID = 'a7c40f631fc920687.20179984', OEVATTBE_NAME='name', OEVATTBE_RATE='8'";

        $oDb->execute($sql);

        $sql = "INSERT INTO oevattbe_articlevat SET OEVATTBE_ARTICLEID = '1126', OEVATTBE_COUNTRYID = 'a7c40f631fc920687.20179984', OEVATTBE_VATGROUPID = '1'";

        $oDb->execute($sql);
    }

    /**
     * Prepare article list object for testing
     *
     * @param string $sUserStatus user status
     *
     * @return oxArticleList
     */
    protected function _getArticleList($sUserStatus = 'notLocal')
    {
        $oArticleList = oxNew("oxArticleList");
        $oArticle = $oArticleList->getBaseObject();

        if ($sUserStatus != 'notLoggedIn') {
            $oUser = $this->getMock("oxUser", array("getTbeCountryId", 'isLocalUser'));
            $oUser->expects($this->any())->method("getTbeCountryId")->will($this->returnValue('a7c40f631fc920687.20179984'));
            $oUser->expects($this->any())->method("isLocalUser")->will($this->returnValue(($sUserStatus=='local')));
            $oArticle->setUser($oUser);
        }

        return $oArticleList;
    }
}
