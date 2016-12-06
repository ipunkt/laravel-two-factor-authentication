<?php

namespace Ipunkt\Laravel\TwoFactorAuthentication;

use Crypt;
use ParagonIE\ConstantTime\Base32;

trait TwoFactorSupport
{
    /**
     * is two factor authentication enabled
     *
     * @return bool
     */
    public function twoFactorEnabled(): bool
    {
        return $this->google2fa_secret !== null;
    }

    /**
     * generates two factor secret
     *
     * @param bool $force
     *
     * @return string
     */
    public function generateTwoFactorSecret(bool $force = false): string
    {
        if ($this->google2fa_secret === null || $force) {
            $randomBytes = random_bytes(10);

            $secret = Base32::encodeUpper($randomBytes);
            $this->google2fa_secret = Crypt::encrypt($secret);
            $this->save();

            return $secret;
        }

        if ($this->google2fa_secret !== null) {
            return Crypt::decrypt($this->google2fa_secret);
        }

        return '';
    }
}