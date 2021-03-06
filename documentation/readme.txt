==Title==
OXID eShop eVAT

==Author==
OXID eSales AG

==Prefix==
oe

==Version==
1.0.0

==Link==
http://www.oxid-esales.com

==Mail==
info@oxid-esales.com

==Description==
This module change how Shop calculates VAT for TBE products.
Shop without module always use Shop VAT rate which should be configured by the Shop location country.
With this module Shop separate articles in to two groups: TBE and Not TBE services.
Not TBE services are calculated with default Shop VAT rate (regular way).
TBE articles are calculated with user location country VAT rate.

==Extend==
*oxarticle
--getCacheKeys
--buildSelectString
*oxarticlelist
--_getCategorySelect
--_getVendorSelect
--_getManufacturerSelect
--_getPriceSelect
--loadTagArticles
--loadActionArticles
--loadArticleAccessoires
--loadArticleCrossSell
--loadNewestArticles
--loadTop5Articles
--_getArticleSelect
*oxuser
--login
--logout
--save
*oxsearch
--_getSearchSelect
*oxvatselector
--getArticleUserVat
*oxbasket
*oxcmp_basket
--render
*oxorder
--validateOrder
--delete
--finalizeOrder
--_loadFromBasket
*basket
--render
*order
--render
--_getNextStep
*oxbasketcontentmarkgenerator
--__construct
--getMark
--_formMarks
*order_main
--render
*oxcountry
*oxcategory
*article_extend_ajax
--addCat
*article_main
--addToCategory
*category_main_ajax
--addArticle
*category_main_ajax
--addArticle
--removeArticle

==Extend invoicePDF==
*oxorder
--_setOrderArticlesToPdf

==Installation==
1. Copy the module source files to your shop directory.
2. Activate the module.
3. Clean database cache from source/tmp/ directory.