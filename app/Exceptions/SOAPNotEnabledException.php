<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class SOAPNotEnabledException extends \Exception
{
    protected $message = 'SOAP must be enabled';

    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
