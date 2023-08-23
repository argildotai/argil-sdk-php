# Argil PHP SDK

Welcome to the Argil PHP SDK. This library provides a simple and intuitive interface to interact with Argil's API, allowing you to leverage the power of AI-driven workflows and automations in your PHP applications.

For the full Argil documentation, please visit https://docs.argil.ai.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)
- [Acknowledgements](#acknowledgements)
- [Contact](#contact)

## Installation

This library is distributed on `composer`. In order to add it as a dependency, run the following command:

```bash
composer require argil/sdk
```

## Usage

Here is a quick example of how to use the Argil PHP SDK:

1. SDK instantiation

You can either provide the ARGIL_API_KEY environment variable and instantiate the SDK without passing any parameters:

```php
use Argil\ArgilSdk;

$sdk = new ArgilSdk();
```

Or pass the configuration parameters to the constructor:

```php
use Argil\ArgilSdk;

$sdk = new ArgilSdk([
  'apiKey' => 'your-api-key', # optional, can be provided with an environment variable named ARGIL_API_KEY
  'apiUrl' => 'https://api.argil.ai', # optional, default is 'https://api.argil.ai'
  'synchronous' => false, # optional, default is false. Defines if the workflows should run synchronously or not.
  'defaultSyncTimeout' => 60000, # optional, default is 60000 milliseconds for synchronous requests
  'defaultAsyncTimeout' => 2000, # optional, default is 2000 milliseconds for asynchronous requests
]);
```

2. Use the SDK client to call Argil's API routes

```php
# Run a workflow
$run = $sdk->workflows->run(
  'workflow-id',
  [
    "input_field_name1" => $input_value1,
    "input_field_name2" => $input_value2
    # Input fields depend on the workflow you run, please look at our full documentation.
  ],
  [ # An optional runtime config array to set options for this specific run.
    'timeout' => 5000, # optional, can override the default timeout for this specific request
    'synchronous' => true # optional, can override the default synchronous flag for this specific request
  ]
);

# Get a workflow run
$workflowRun = $sdk->workflowRuns->get($run['id']);

# Get all workflow runs
$workflowRuns = $sdk->workflowRuns->list();
```

## API Reference

The Argil PHP SDK provides the following classes:

- `ArgilSdk`: The main class that provides access to the different services.
- `Workflows`: A class for interacting with the Workflows service of the Argil API.
- `WorkflowRuns`: A class for interacting with the WorkflowRuns service of the Argil API.
- `ArgilSdkGlobalConfig`: A class for managing the global configuration for the SDK.
- `ArgilSdkRuntimeConfig`: A class for managing the runtime configuration for the SDK.
- `ArgilError`: A custom error class for providing more detailed and specific error messages.

For more detailed information, please refer to the source code and inline comments.

## Contributing

We welcome contributions from the community.

## License

This project is licensed under the GPL-3.0-or-later license. For more information, see the [LICENSE.md](LICENSE.md) file.

## Support

If you encounter any problems or have any questions, please open an issue on our [GitHub repository](https://github.com/argildotai/argil-sdk-php/issues).

## Acknowledgements

This project uses the following open-source packages:

- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle): PHP HTTP client that makes it easy to send HTTP requests and trivial to integrate with web services.

## Contact

For any inquiries, please contact us at briva@argil.ai.
