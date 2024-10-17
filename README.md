<p align="center">
  <img src="https://www.inbs.software/assets/img/logo-pa.svg" alt="PanelAlpha Logo" width="200">
</p>

<h3 align="center">Gain Advantage With Full WordPress Automation</h3>

---

## About

The `Sample Email Server` module provides a sample implementation of an email server integration. This class includes methods for managing email domains, testing the connection to the email server API, and retrieving usage statistics.

## Features

- **Manage Email Domains**
    - List All Email Domains
    - Find Email Domain
    - Create Email Domain
    - Update Email Domain
    - Delete Email Domain
- **Manage Mailboxes assigned to Email Domain**
    - List All Mailboxes
    - Create Mailbox
    - Update Mailbox
    - Delete Mailbox
    - Get Mailbox Configuration
    - Create SSO to Webmail
- **Manage Forwarders assigned to Email Domain**
    - List All Forwarders
    - Create Forwarder
    - Delete Forwarder
- **Get Usage for Panelalpha Service**

Ensure all features listed are implemented within the module to provide comprehensive functionality.

## Creating and Installing Your Own Module

To create and install your own email server integration module, follow these steps:

1. **Download the Sample Module**
    - Start by downloading or cloning the `Sample Email Server` module as a base template.
2. **Implement Required Methods**
    - Fill in the necessary methods and configurations specific to the email server you are integrating with.
    - Ensure all methods defined in interfaces are properly implemented.
3. **Customize the Module**
    - Modify the module according to your requirements, including changing the class name, namespace, and any specific logic.
    - Add required configuration fields for connection to the email Server API.
4. **Copy the Module**
    - Copy it to the `app/Lib/Integrations/EmailServers` directory according to the namespace used in your module.
5. **Verify Dependencies**
    - Ensure that all dependencies required by the module are correctly installed and configured.
6. **Add Translations**
    - Incorporate necessary keys and translations into the `integrations.php` file located in the translations directory to ensure the module integrates seamlessly with the rest of the application.

## Configuration

The module requires the following configuration fields for connecting to the email server API:

- `api_url`: The URL to the email server's API.
- `api_key`: API key required for authentication.

Additionally, creating email domain may require configuration fields such as `example_config`, which can be dynamically fetched using the `getAvailableServerValues` method.

## Adding Translations

Add appropriate keys and translations to the `integrations.php` file in the translations directory to ensure proper display of error messages, configuration, and other user communications.

## Logo and Links

- The email server's logo can be placed in the path specified in the `$logo` variable. Ensure the path is correct and accessible.
- A link to the official website of the email server can be included in the `$link` variable if available. Verify that the link is accurate and leads to the correct website.

## License

This repository is licensed under the [MIT License](https://github.com/panelalpha/PanelAlpha-Translations/blob/main/LICENSE). Ensure the link to the license is current and points to the correct version.