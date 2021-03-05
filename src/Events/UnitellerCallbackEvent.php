<?php

namespace Rir\UnitellerAdapter\Events;

class UnitellerCallbackEvent
{
    protected $requestPayload;

    public function __construct(array $requestPayload)
    {
        $this->requestPayload = $requestPayload;
    }

    public function getRequestPayload()
    {
        return $this->requestPayload;
    }
}
