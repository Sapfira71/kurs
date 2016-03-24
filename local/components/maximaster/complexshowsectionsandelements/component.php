<?

if(!empty($_REQUEST['SECTION_ID']) || !empty($_REQUEST['BRAND_ID'])) {
    $this->IncludeComponentTemplate('sections');
} elseif(!empty($_REQUEST['ELEMENT_ID'])) {
    $this->IncludeComponentTemplate('element');
}