<?php

namespace app\api;

interface SecureModelInterface
{
    public function authenticate();
    public function getAuthenticatedUserId();
}
