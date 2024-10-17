<p align="center">
  <img src="https://www.inbs.software/assets/img/logo-pa.svg" alt="PanelAlpha Logo" width="200">
</p>

<h3 align="center">Gain Advantage With Full WordPress Automation</h3>

---

# Sample Email Server Integration

## About

The `Sample Email Server Integration` provides a sample implementation of an email server integration in PanelAlpha.

## Supported features

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

Ensure all features listed are implemented within the integration to provide comprehensive functionality.

## Creating and Installing Your Own Integration

To create and install your own email server integration, follow these steps:

1. **Download the Sample Integration**
    - Start by downloading or cloning the `Sample Email Server Integration` as a base template.
2. **Implement Required Methods**
    - Fill in the necessary methods and configurations specific to the email server you are integrating with.
3. **Customize the Integration**
    - Modify the integration according to your requirements, including changing the class name, namespace, and any specific
      logic.
    - Add required configuration fields for connection to the email Server API.
4. **Copy the Integration**
    - Copy it to the `app/Lib/Integrations/EmailServers` directory according to the namespace used in your integration.

## License

This repository is licensed under
the [MIT License](https://github.com/panelalpha/sample-email-provisioning-module/blob/main/LICENSE).