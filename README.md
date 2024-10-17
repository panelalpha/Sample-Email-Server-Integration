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
    Start by downloading or cloning the `Sample Email Server Integration` as a base template.
2. **Apply Required Changes**  
    Every reference of "SampleEmailServer" should be replaced with your integration name, e.g.
    - rename file app/Lib/Integrations/EmailServers/**SampleEmailServer.php** to **MyEmailProvider.php**
    - replace **class SampleEmailServer** with **class MyEmailProvider** in file
      * app/Lib/Integrations/EmailServers/MyEmailProvider.php
    - rename directory app/Lib/Integrations/EmailServers/**SampleEmailServer** to **MyEmailProvider**
    - replace namespace App\Lib\Integrations\EmailServers\\**SampleEmailServer** with **MyEmailProvider** in following files:
      * app/Lib/Integrations/EmailServers/MyEmailProvider/Domain.php
      * app/Lib/Integrations/EmailServers/MyEmailProvider/Domain/Account.php
      * app/Lib/Integrations/EmailServers/MyEmailProvider/Domain/Forwarder.php
3. **Upload the Integration**  
    Upload contents of `app` directory to `/opt/panelalpha/app/packages/api/app` directory on the server where PanelAlpha is installed
4. **Activate the Integration**  
    Run following command as root on the server where PanelAlpha is installed:
      ```
      docker compose -f /opt/panelalpha/app/docker-compose.yml exec api php artisan integrations:sync
      ```
5. **Replace example code with your own within all methods in all files**  
    Refer to comments inside the files for details.

## License

This repository is licensed under
the [MIT License](https://github.com/panelalpha/sample-email-provisioning-module/blob/main/LICENSE).