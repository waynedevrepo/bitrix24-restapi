# Bitrix24 REST API

## Build status
Integration tests run in GitHub actions with real Bitrix24 portal 

## Bitrix24 REST API ✨FEATURES✨

Support both auth modes:

- [x] work with auth tokens for Bitrix24 applications in marketplace
- [x] work with incoming webhooks for simple integration projects for current portal

Domain core events:
  - [x] Access Token expired
  - [x] Bitrix24 portal domain url changed

API - level features

- [x] Auto renew access tokens
- [x] List queries with «start=-1» support
- [ ] offline queues

Performance improvements 🚀

- Batch queries implemented with [PHP Generators](https://www.php.net/manual/en/language.generators.overview.php) – constant low memory and
  low CPI usage
    - [x] batch read data from bitrix24
    - [x] batch write data to bitrix24
    - [ ] write and read in one batch package
    - [ ] composite batch queries to many entities (work in progress)
- [ ] read without count flag

Low-level tools to devs:
- [ ] Rate-limit strategy
- [ ] Retry strategy for safe methods


## Development principles

- Good developer experience
    - auto-completion of methods at the IDE
    - typed method call signatures
    - typed results of method calls
    - helpers for typical operations
- Good documentation
    - documentation on the operation of a specific method containing a link to the official documentation
    - documentation for working with the SDK
- Performance first:
    - minimal impact on client code
    - ability to work with large amounts of data with constant memory consumption
    - efficient operation of the API using batch requests
- Modern technology stack
    - based on [Symfony HttpClient](https://symfony.com/doc/current/http_client.html)
    - actual PHP versions language features
- Reliable:
    - test coverage: unit, integration, contract
    - typical examples typical for different modes of operation and they are optimized for memory \ performance
## Architecture

### Abstraction layers

```
- http2 protocol via json data structures
- symfony http client
- \Bitrix24\SDK\Core\ApiClient - work with b24 rest-api endpoints
    input: arrays \ strings
    output: Symfony\Contracts\HttpClient\ResponseInterface, operate with strings
    process: network operations 
- \Bitrix24\SDK\Services\* - work with b24 rest-api entities
    input: arrays \ strings
    output: b24 response dto
    process: b24 entities, operate with immutable objects  
```

## Requirements

- php: >=8.2
- ext-json: *
- ext-curl: *

## Examples
### Work with webhook
```php
declare(strict_types=1);

use Bitrix24\SDK\Services\ServiceBuilderFactory;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once  'vendor/autoload.php';

$webhookUrl = 'INSERT_HERE_YOUR_WEBHOOK_URL';

$log = new Logger('bitrix24-php-sdk');
$b24ServiceFactory = new ServiceBuilderFactory(new EventDispatcher(), $log);

// init bitrix24-php-sdk service
$b24Service = $b24ServiceFactory->initFromWebhook($webhookUrl);

// work with interested scope
var_dump($b24Service->getMainScope()->main()->getCurrentUserProfile()->getUserProfile());
var_dump($b24Service->getCRMScope()->lead()->list([],[],['ID','TITLE'])->getLeads()[0]->TITLE);
```

## Tests

Tests locate in folder `tests` and we have two test types.
In folder tests create file `.env.local` and fill environment variables from `.env`.

### Unit tests

**Fast**, in-memory tests without a network I\O For run unit tests you must call in command line

```shell
composer phpunit-run-unit-test
```

### Integration tests

**Slow** tests with full lifecycle with your **test** Bitrix24 portal via webhook.

❗️Do not run integration tests with production portals

For run integration test you must:

1. Create [new Bitrix24 portal](https://www.bitrix24.eu/create.php?p=255670) for development tests
2. Go to left menu, click «Sitemap»
3. Find menu item «Developer resources»
4. Click on menu item «Other»
5. Click on menu item «Inbound webhook»
6. Assign all permisions with webhook and click «save» button
7. Create file `/tests/.env.local` with same settings, see comments in `/tests/.env` file.

```yaml
APP_ENV=dev
BITRIX24_WEBHOOK=https:// your portal webhook url
INTEGRATION_TEST_LOG_LEVEL=500
```

8. call in command line

```shell
composer composer phpunit-run-integration-tests
```

#### PHP Static Analysis Tool – phpstan

Call in command line

```shell
 composer phpstan-analyse
```
