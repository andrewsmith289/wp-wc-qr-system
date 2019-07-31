<?php

/**
 * A singleton wrapping required bacon-qr functionality
 *
 * @link       https://***********
 * @since      1.0.0
 *
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/includes
 */

/**
 * A singleton wrapping required bacon-qr functionality
 *
 * Only encoding is supported.
 *
 * @package    Bcbs_Qr
 * @subpackage Bcbs_Qr/includes
 * @author     *********** <webmaster@***********>
 */
class QrCode {
    private static $inst = NULL;
    private static $renderer = NULL;
    private static $writer = NULL;

    private function __construct() {

    }

    private function maybeInstantiate() {
        if ( ! self::$inst ) {
            self::$inst = new QrSingleton();
        }
    }

    /**
     * Creates a QR code
     * @param string $str The string to encode
     */
    static function saveQrImage( string $str ) {
        self::maybeInstantiate();

        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);
        $writer = new \BaconQrCode\Writer($renderer);
        $writer->writeFile( $str, 'qrcode.png' );


    }

}