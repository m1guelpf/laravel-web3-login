<?php

namespace M1guelpf\Web3Login;

use Elliptic\EC;
use kornrunner\Keccak;
use Illuminate\Support\Str;

class Signature
{
    public function generate(string $nonce) : string
    {
        return str_replace(':nonce:', $nonce, value(config('web3.message', "Hey! Sign this message to prove you have access to this wallet. This won't cost you anything.\n\nSecurity code (you can ignore this): :nonce:")));
    }

    public function verify(string $nonce, string $signature, string $address) : bool
    {
        $message = $this->generate($nonce);

        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign   = ['r' => substr($signature, 2, 64), 's' => substr($signature, 66, 64)];
        $recid  = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }

        $pubkey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);

        return hash_equals(
            (string) Str::of($address)->after('0x')->lower(),
            substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24)
        );
    }
}
