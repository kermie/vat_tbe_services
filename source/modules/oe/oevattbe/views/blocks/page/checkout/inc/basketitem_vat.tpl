[{* product VAT percent *}]
[{assign var="oCountry" value=$oxcmp_basket->getTBECountry()}]
[{assign var="oArticle" value=$basketitem->getArticle()}]
[{assign var="oMarkGenerator" value=$oView->getBasketContentMarkGenerator()}]
<td class="vatPercent">
    [{if $oArticle->isTBEService()}]
        [{if $oxcmp_user }]
            [{if $oxcmp_basket->isTBEValid() }]
                    [{$basketitem->getVatPercent()}]% [{if $oCountry->appliesTBEVAT()}] [{$oMarkGenerator->getMark('tbeService')}] [{/if}]
            [{else }]
                -
            [{/if}]
        [{else}]
            [{$basketitem->getVatPercent()}]% [{$oMarkGenerator->getMark('tbeService')}]
        [{/if}]
    [{else}]
        [{$basketitem->getVatPercent()}]%
    [{/if}]
</td>