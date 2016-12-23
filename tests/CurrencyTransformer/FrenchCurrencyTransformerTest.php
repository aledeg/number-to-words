<?php

namespace NumberToWords\CurrencyTransformer;

class FrenchCurrencyTransformerTest extends CurrencyTransformerTest
{

    public function setUp()
    {
        $this->currencyTransformer = new FrenchCurrencyTransformer();
    }

    public function providerItConvertsMoneyAmountToWords()
    {
        return [
            [100, 'EUR', 'un euro'],
            [200, 'EUR', 'deux euros'],
            [235715, 'EUR', 'deux mille trois cent cinquante-sept euros et quinze centimes'],
            [1522501, 'EUR', 'quinze mille deux cent vingt-cinq euros et un centime'],
            [754414599, 'USD', 'sept millions cinq cent quarante-quatre mille cent quarante-cinq dollars américains et quatre-vingt-dix-neuf cents'],
            [754414599, 'CAD', 'sept millions cinq cent quarante-quatre mille cent quarante-cinq dollars canadiens et quatre-vingt-dix-neuf cents'],
            [754414599, 'AUD', 'sept millions cinq cent quarante-quatre mille cent quarante-cinq dollars australiens et quatre-vingt-dix-neuf cents'],
            [110, 'BGN', 'un lev et dix stotinkis'],
            [201, 'BGN', 'deux leva et un stotinki'],
            [110, 'HUF', 'un forint et dix fillér'],
            [201, 'HUF', 'deux forints et un fillér'],
            [110, 'PLN', 'un złoty et dix groszy'],
            [201, 'PLN', 'deux złotys et un grosz'],
            [110, 'RON', 'un leu et dix bani'],
            [201, 'RON', 'deux lei et un ban'],
            [110, 'ALL', 'un lek et dix qindarkas'],
            [201, 'ALL', 'deux lekë et un qindarka'],
            [110, 'BYN', 'un rouble biélorusse et dix kapieïkas'],
            [201, 'BYN', 'deux roubles biélorusses et un kapieïka'],
            [110, 'BAM', 'un mark convertible et dix fenings'],
            [201, 'BAM', 'deux marks convertibles et un fening'],
            [110, 'MKD', 'un denar et dix deni'],
            [201, 'MKD', 'deux denars et un deni'],
            [110, 'MDL', 'un leu moldave et dix bani'],
            [201, 'MDL', 'deux lei moldaves et un ban'],
            [110, 'RSD', 'un dinar serbe et dix paras'],
            [201, 'RSD', 'deux dinars serbes et un para'],
        ];
    }
}
