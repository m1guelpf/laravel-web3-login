# Allow your users to login with their Ethereum wallet

[![Latest Version on Packagist](https://img.shields.io/packagist/v/m1guelpf/laravel-web3-login.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/laravel-web3-login)
[![Total Downloads](https://img.shields.io/packagist/dt/m1guelpf/laravel-web3-login.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/laravel-web3-login)

Allow your users to link their Ethereum wallet to their account to skip entering their login credentials.

## Installation

You can install the package via composer:

```bash
composer require m1guelpf/laravel-web3-login
```

## Usage

This package takes care of everything you need on the backend. While there are many different ways of asking the user to sign a message with their wallet, we'll be using `web3modal` and `ethers` to maximize the support for wallet providers.

To get started, you need to have the user register a new credential. You can do so by presenting them with a modal when they login, or by adding the option to their settings page.

```js
import axios from "axios";
import { ethers } from "ethers";
import Web3Modal from "web3modal";

const web3Modal = new Web3Modal({
	cacheProvider: true,
	providerOptions: {}, // add additional providers here, like WalletConnect, Coinbase Wallet, etc.
});

const onClick = async () => {
	const message = await axios.get("/_web3/signature").then((res) => res.data);
	const provider = await web3Modal.connect();

	provider.on("accountsChanged", () => web3Modal.clearCachedProvider());

	const web3 = new ethers.providers.Web3Provider(provider);

	axios.post("/_web3/link", {
		address: await web3.getSigner().getAddress(),
		signature: await web3.getSigner().signMessage(message),
	});
};
```

Then, on the login page, you can provide an option to log in with their wallet.

```js
import axios from "axios";
import { ethers } from "ethers";
import Web3Modal from "web3modal";

const web3Modal = new Web3Modal({
	cacheProvider: true,
	providerOptions: {}, // add additional providers here, like WalletConnect, Coinbase Wallet, etc.
});

const onClick = async () => {
	const message = await axios.get("/_web3/signature").then((res) => res.data);
	const provider = await web3Modal.connect();

	provider.on("accountsChanged", () => web3Modal.clearCachedProvider());

	const web3 = new ethers.providers.Web3Provider(provider);

	axios.post("/_web3/login", {
		address: await web3.getSigner().getAddress(),
		signature: await web3.getSigner().signMessage(message),
	});
};
```

## Configs

If you want to change the message that is sent to the user, you can publish the config file and change it.

```bash
php artisan vendor:publish --provider="M1guelpf\Web3Login\Web3LoginServiceProvider" --tag="config"
```

This command will publish a config file to `config/web3.php` with the following options:

```php
[
	// Message that is returned to the user in the /_web3/signature route
	'message' => "Hey! Sign this message to prove you have access to this wallet. This won't cost you anything.\n\nSecurity code (you can ignore this): :nonce:",
	// Routes created by this package
    'routes' => ['login', 'register', 'link', 'signature'],
]
```

For example, if you want to disable user registration through this package, you can remove `register` from `routes` config.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Miguel Piedrafita](https://github.com/m1guelpf)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
