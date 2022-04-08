<?php

namespace EasyHttp\LayerContracts\Common;

use EasyHttp\LayerContracts\Contracts\Request\HttpSecurityContext;

class SecurityContext implements HttpSecurityContext
{
    protected string $certificate;
    protected string $privateKey;

    public function getCertificate(): string
    {
        return $this->certificate;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function hasCertificate(): bool
    {
        return $this->certificate ?? false;
    }

    public function hasPrivateKey(): bool
    {
        return $this->privateKey ?? false;
    }

    public function setCertificate(string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function setPrivateKey(string $privateKey): self
    {
        $this->privateKey = $privateKey;

        return $this;
    }
}
