<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ExchangeRate
{

    private $url;


    public function __construct()
    {
        $this->url='http://www.boc.cn/sourcedb/whpj/';

    }

    public function GetExchangeRate()
    {

        $finalouput=array();


        $ch=curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        $output=curl_exec($ch);
        curl_close($ch);





/** Obtain the TABLE tag on page */

        preg_match_all('/<table[.\s\S]*?>[.\s\S]*?<\/table>/',$output,$table,PREG_PATTERN_ORDER);


/** The second table is about foreign exchange ($table[0][1]) */
/** Obtain <tr> from foreign exchange table */

        preg_match_all('/<tr>[.\s\S]*?<\/tr>/',$table[0][1],$trs,PREG_PATTERN_ORDER);


        for($i=0;$i<COUNT($trs[0]);$i++)
        {
            $currency=array();

/** Obtain td from tr, each td contains a selling or buying rate of a currency*/
            if(preg_match_all('/<td>[.\s\S]*?<\/td>/',$trs[0][$i],$tds,PREG_PATTERN_ORDER))
            {

                for($j=0;$j<COUNT($tds[0]);$j++)
                {
/** obtain the data from td */
                    preg_match_all("|<[^>]+>(.*)</[^>]+>|U",$tds[0][$j],$out,PREG_PATTERN_ORDER);

                    $temp=$out[1][0];


                    array_push($currency,$temp);
                    
                }

            }

           if(COUNT($currency)>0)
           {
               array_push($finalouput,$currency);
           }



        }

return $finalouput;





    }



}
