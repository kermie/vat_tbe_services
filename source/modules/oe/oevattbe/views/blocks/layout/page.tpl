[{if $oxcmp_basket->showOeVATTBECountryChangedError() }]
    [{assign var="oCountry" value=$oxcmp_basket->getOeVATTBECountry()}]
    [{assign var="sMessage" value="OEVATTBE_RESIDENCE_COUNTRY_CHANGED_MESSAGE"|oxmultilangassign:$oCountry->getOeVATTBEname()}]
    [{include file="message/success.tpl" statusMessage=$sMessage}]
[{/if}]
[{$smarty.block.parent}]