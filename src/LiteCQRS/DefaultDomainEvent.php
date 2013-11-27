<?php
namespace LiteCQRS;

use LiteCQRS\Util;

abstract class DefaultDomainEvent implements DomainEvent
{
    /**
     * @var MessageHeader
     */
    private $messageHeader;

    public function __construct(array $data = array())
    {
        foreach ($data as $key => $value) {
            if (!property_exists($this, $key )) {
                throw new \RuntimeException("Property " . $key . " is not a valid property on event " . $this->getEventName());
            }

            $this->$key = $value;
        }

        $this->date = Util::createMicrosecondsNow();
    }

    public function getEventName()
    {
        $class = get_class($this);

        if (substr($class, -5) === "Event") {
            $class = substr($class, 0, -5);
        }

        if (strpos($class, "\\") === false) {
            return $class;
        }

        $parts = explode("\\", $class);
        return end($parts);
    }

    public function getDate()
    {
        return $this->date;
    }
}

