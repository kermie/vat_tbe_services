[{$smarty.block.parent}]
[{if $oViewConf->oeVATTBEShowTBEArticlePriceNotice($product) && $oView->isVatIncluded()}]
[{if !($product->hasMdVariants() || ($oViewConf->showSelectListsInList() && $product->getSelections(1)) || $product->getVariants())}]
    <strong><span>**</span></strong>
[{/if}]
[{/if}]