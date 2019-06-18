<?php
use Illuminate\Support\Facades\Storage;

/**
 * Created by PhpStorm.
 * User: shpaq
 * Date: 6/16/2019
 * Time: 3:16 PM
 */
/**
 * @param string $type
 * @param int $length
 * @return string
 */
/**Function borrowed from: https://gist.github.com/raveren/5555297 **/

function getSecureToken($type = 'alnum', $length = 32)
{
    switch ( $type ) {
        case 'alnum':
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'alpha':
            $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 'hexdec':
            $pool = '0123456789abcdef';
            break;
        case 'numeric':
            $pool = '0123456789';
            break;
        case 'nozero':
            $pool = '123456789';
            break;
        case 'distinct':
            $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
            break;
        default:
            $pool = (string) $type;
            break;
    }


    $crypto_rand_secure = function ( $min, $max ) {
        $range = $max - $min;
        if ( $range < 0 ) return $min; // not so random...
        $log    = log( $range, 2 );
        $bytes  = (int) ( $log / 8 ) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ( $rnd >= $range );
        return $min + $rnd;
    };

    $token = "";
    $max   = strlen( $pool );
    for ( $i = 0; $i < $length; $i++ ) {
        $token .= $pool[$crypto_rand_secure( 0, $max )];
    }
    return $token;
}

function excelParser($filename) {
    $file_path = "public/excel/$filename";
    if (!Storage::exists($file_path)) {
        return false;
    }

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    $full_path = $storagePath.$file_path;

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $reader->setReadDataOnly(true);
    try {
        $spreadsheet = $reader->load($full_path);
        $worksheet = $spreadsheet->getActiveSheet();
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        return false;
    }
    $returning_array = [];
    $columns = [];


    foreach($worksheet->getRowIterator() as $row_id => $row) {
        $i = 0;
        $arr = [];
        foreach($row->getCellIterator() as $cell) {
            if($cell->getRow() === 1) {
                $columns[] = $cell->getValue();
            } else {
                $arr[$columns[$i]] = $cell->getCalculatedValue();
                $i++;


                if($i===sizeof($columns)): break; endif;
            }
        }
        if($row_id !== 1) {
            $returning_array[] = $arr;
        }
    }
    return $returning_array;
}