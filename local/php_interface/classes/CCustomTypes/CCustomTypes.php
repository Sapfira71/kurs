<?php

class CCustomTypeDesignerDate
{
    function GetUserTypeDescription()
    {
        return array(
            'PROPERTY_TYPE' => 'S',
            'USER_TYPE' => 'designerdate',
            'DESCRIPTION' => 'Дизайнер и дата выпуска модели',
            'GetPropertyFieldHtml' => array('CCustomTypeDesignerDate', 'GetPropertyFieldHtml'),
            'ConvertToDB' => array('CCustomTypeDesignerDate', 'ConvertToDB'),
            'ConvertFromDB' => array('CCustomTypeDesignerDate', 'ConvertFromDB')
        );
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $value['DESCRIPTION'] = unserialize($value['DESCRIPTION']);

        $designers = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => 4,
                'ACTIVE' => 'Y'
            ),
            false,
            false,
            array('ID', 'NAME')
        );

        echo '<div>Дата выпуска модели: ';
        global $APPLICATION;
        $APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
                "SHOW_INPUT" => "Y",
                "FORM_NAME" => "",
                "INPUT_NAME" => $strHTMLControlName['VALUE'],
                "INPUT_NAME_FINISH" => "",
                "INPUT_VALUE" => $value['VALUE'],
                "INPUT_VALUE_FINISH" => "",
                "SHOW_TIME" => "N",
                "HIDE_TIMEBAR" => "Y"
            )
        );
        echo '</div><br>';

        $return = '<tr><td>';

        $return .= '<div>Дизайнер: <select name="'.$strHTMLControlName['DESCRIPTION'] . '[NAME]">';
        $return .= '<option value="">(выберите квалификацию)</option>';
        while ($designer = $designers->GetNext()){
            $return .= '<option value="' .$designer["ID"]. '"';
            if ($designer["ID"] == $value['DESCRIPTION']['NAME']){
                $return .= 'selected="selected"';
            }
            $return .= '>' .$designer["NAME"]. '</option>';
        }
        $return .= '</select></div><br>';

        $return .= '<div>Бренд: <input type="text" size="30" name="' . $strHTMLControlName['DESCRIPTION'] . '[BRAND]" value="' . $value['DESCRIPTION']['BRAND'] . '" ></div>';

        $return .= '</td></tr>';

        return $return;
    }

    function ConvertToDB($arProperty, $value)
    {
        $value['DESCRIPTION'] = serialize($value['DESCRIPTION']);
        return $value;
    }

    function ConvertFromDB($arProperty, $value)
    {
        return $value;
    }


}