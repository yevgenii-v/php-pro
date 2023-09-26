<?php

namespace App\Services\Proxy;

use JsonSerializable;

class ProxyDTO implements JsonSerializable
{
    public function __construct(
        protected string $username,
        protected string $password,
        protected string $ip,
        protected int $port,
    ) {
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    public function getData(): string
    {
        return 'http://' . $this->username . ':' . $this->password . '@' . $this->ip . ':' . $this->port;
    }

    public function jsonSerialize(): array
    {
        return [
            'username'  => $this->username,
            'password'  => $this->password,
            'ip'        => $this->ip,
            'port'      => $this->port,
        ];
    }
}
