<?php
/*
 * IMPORTANT: The following constant must be set to true when the page/site is live. This is used to determine whether
 * to use the live or testing URLs for Derrick/Gigya.
 */
define('IS_LIVE', true);

// Campaign name - this must be the client name followed by the year.
$campaign = 'compareTheMarket2018';

// Set to true if the site uses multiple brands.
$multiple_brands = true;

// Set the Krux tracking category or categories - See ../_config/data-shared.include.php. If krux tracking isn't
//  needed, this variable can be deleted.
$kruxCategories = array(
    'travel'
);

/**
 * $client array contains the following variables:
 *
 *    ['key']        Client key, which will be used for tracking in analytics.
 *    ['slogan']    The slogan will be the alt/fallback text for the client logo.
 *    ['link']    The url for the link on the client logo in the header.
 *    ['name']    Client name, used in the opt-in text.
 */
$client = array(
    'key' => 'comparethemarket',
    'slogan' => 'comparethemarket.com',
    'link' => 'https://www.comparethemarket.com/customer-rewards/',
    'name' => 'comparethemarket.com'
);

/**
 * $siteDetails array contains the following variables:
 *
 *    ['brands']     The brands for this campaign (must use a key value from the $brands array).
 *    ['baseURL']    The url this campaign will be served from. Change 'template' to your campaign directory name.
 *    ['localPath']  The system path for this campaign. Again, change 'template' to your campaign directory name.
 *    ['database']   The database for this campaign. This will probably be 'competitions' and the current year, i.e:
 *                      'competitions2016'.
 *    ['table']      The table name should be the brand followed by the competition name, i.e: 'heartSpecsavers2016'.
 *                      For campaigns with multiple brands using different tables, use an array with the brand
 *                      shortcode as the key for the table name, i.e: array('heart' => 'heartCompname2016')
 */
$siteDetails = array(
    'brands' => array('heart', 'capital', 'gold', 'xtra', 'smooth', 'radiox', 'lbc', 'classic'),
    'baseURL' => thisProtocol() . '://' . $_SERVER['HTTP_HOST'] . '/compare-the-market/',
    'localPath' => $_SERVER['DOCUMENT_ROOT'] . '/compare-the-market/',
    'database' => 'competitions2018',
    'table' => array(
        'heart' => 'heartCompareTheMarket2018',
        'capital' => 'capitalCompareTheMarket2018',
        'gold' => 'goldCompareTheMarket2018',
        'xtra' => 'xtraCompareTheMarket2018',
        'smooth' => 'smoothCompareTheMarket2018',
        'radiox' => 'radioxCompareTheMarket2018',
        'lbc' => 'lbcCompareTheMarket2018',
        'classic' => 'classicCompareTheMarket2018',
    )
);

$brandLogos = array(
//    'capital' => 'Capital_UK.svg',
    'capital' => 'Capital_White.svg',
//    'heart' => 'heart_red_strap.svg',
    'heart' => 'Heart_White_Strap.svg',
//    'classic' => 'Classic_Black_min.svg',
    'classic' => 'Classic_white_min.svg',
//    'lbc' => 'LBC_Colour_Strap.svg',
    'lbc' => 'LBC_White_Strap.svg',
    'smooth' => 'Smooth_Colour_Freq_Strap.png',
    'radiox' => 'RadioX_Landscape_White.svg',
//    'radiox' => 'RadioX_Landscape_Green_Info.svg',
    'gold' => 'Gold.svg',
    'xtra' => 'xtra_white.svg',
);
