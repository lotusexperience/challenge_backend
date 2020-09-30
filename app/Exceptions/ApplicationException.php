<?php

namespace App\Exceptions;

use Exception;

class ApplicationException extends Exception {
  public $originalExceptionData;
}