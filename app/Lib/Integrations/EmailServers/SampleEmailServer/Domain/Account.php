<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;

use App\Lib\Integrations\EmailServers\AbstractEmailServer\Domain\AbstractAccount;
use App\Lib\Interfaces\Integrations\EmailServer\Domain\AccountInterface;

/**
 * Class Account
 *
 * This class handles email account operations, such as creating, updating, deleting,
 * and retrieving configurations for email accounts associated with a domain on an email server.
 */
class Account extends AbstractAccount implements AccountInterface
{
    /**
     * Creates a new email account for the given domain.
     *
     * Parameters:
     * - email (string)   : The email address to be created
     * - password (string): The password for the email account
     * - quota (int)      : The storage quota for the email account in MB
     *
     * @param array $params Array containing 'email', 'password', and 'quota'
     * @return void
     */
    public function create(array $params): void
    {
        // Example API call to create a new email account
        $this->emailServer()->sampleAPI()->createEmailAccount($this->emailDomain->domain, $params);
    }

    /**
     * Deletes an email account for the given domain.
     *
     * @param string $email The email address to be deleted
     * @return void
     */
    public function delete(string $email): void
    {
        // Example API call to delete an email account
        $this->emailServer()->sampleAPI()->deleteEmailAccount($this->emailDomain->domain, $email);
    }

    /**
     * Updates an existing email account for the given domain.
     *
     * Parameters:
     * - email (string)   : The email address to be updated
     * - password (string): The new password for the email account
     * - quota (int)      : The new storage quota for the email account in MB
     *
     * @param string $email The email address to be updated
     * @param array $params Array containing updated account details ('password', 'quota', etc.)
     * @return void
     */
    public function update(string $email, array $params): void
    {
        // Example API call to update an email account
        $this->emailServer()->sampleAPI()->updateEmalAccount($this->emailDomain->domain, $email, $params);
    }

    /**
     * Retrieves the configuration settings for a given email account.
     *
     * @param string $email The email address whose configuration is being retrieved
     * @return array An array containing the email account's configuration details
     */
    public function getConfiguration(string $email): array
    {
        // Example API call to retrieve email account configuration
        $result = $this->emailServer()->sampleAPI()->getEmailAccount($this->emailDomain->domain, $email);

        // Return the formatted configuration data
        return [
            "account" => 'test@example.com',
            "display" => 'test@example.com',
            "domain" => 'example.com',
            "inbox_host" => 'example.com',
            "pop3_port" => 995,
            "pop3_insecure_port" => 110,
            "imap_port" => 993,
            "imap_insecure_port" => 443,
            "inbox_username" =>  'test@example.com',
            "mail_domain" => 'example.com',
            "smtp_host" => 'example.com',
            "smtp_insecure_port" => 25,
            "smtp_port" => 465,
            "smtp_username" => 'test@example.com',
        ];
    }

    /**
     * Retrieves a Single Sign-On (SSO) URL for accessing webmail for a given email account.
     *
     * @param string $email The email address for which the SSO URL is retrieved
     * @return string  // The SSO URL to access the webmail interface
     */
    public function webmailSsoUrl(string $email): string
    {
        $result = $this->emailServer()->sampleAPI()->webmailSso($this->emailDomain->domain, $email);

        return "https://example.com/";
    }
}
