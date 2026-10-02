<?php

namespace App\Exceptions;

use RuntimeException;

/** Le serveur Rasa est injoignable ou a répondu de façon inexploitable. */
class ChatbotUnavailableException extends RuntimeException
{
}
