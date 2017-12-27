<?php 
namespace App\Vendor\BrowserDetect\Facade;

use Illuminate\Support\Facades\Facade;

class Parser extends Facade {

    /**
     * {@inheritDocs}
     */
    protected static function getFacadeAccessor() {  return \App\Vendor\BrowserDetect\Parser::class; }
}