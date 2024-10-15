<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;

use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Interfaces\Integrations\EmailServer\Domain\AccountInterface;
use App\Models\EmailDomain;
use Exception;

/**
 * Class Account
 *
 * This class handles email account operations, such as creating, updating, deleting,
 * and retrieving configurations for email accounts associated with a domain on an email server.
 *
 * This class implements AccountInterface.
 */
class Account implements AccountInterface
{
    /**
     * Constructor for the Account class.
     *
     * The EmailDomain model includes the following attributes:
     * - id (int)               : Unique identifier of the model
     * - user_id (int)          : ID of the associated user
     * - service_id (int)       : ID of the associated service
     * - server_account_id (int): ID of the associated server account
     * - domain (string)        : Domain name
     * - details (array)        : Additional details about the domain
     *
     * @param SampleEmailServer $emailServer Instance of the email server being used
     * @param EmailDomain $emailDomain Instance of the EmailDomain model
     */
    public function __construct(private SampleEmailServer $emailServer, private EmailDomain $emailDomain)
    {
    }

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
     * @throws Exception If the account creation fails
     */
    public function create(array $params): void
    {
        // Example API call to create a new email account
        $this->emailServer->apiCall('POST', '/email/domain/' . $this->emailDomain->domain . 'accounts', $params);
    }

    /**
     * Deletes an email account for the given domain.
     *
     * @param string $email The email address to be deleted
     * @return void
     * @throws Exception If the account deletion fails
     */
    public function delete(string $email): void
    {
        // Example API call to delete an email account
        $this->emailServer->apiCall('DELETE', '/email/domain' . $this->emailDomain->domain . '/accounts/' . $email);
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
     * @throws Exception If the account update fails
     */
    public function update(string $email, array $params): void
    {
        // Example API call to update an email account
        $this->emailServer->apiCall('PUT', '/email/domain' . $this->emailDomain->domain . '/accounts/' . $email, $params);
    }

    /**
     * Retrieves the configuration settings for a given email account.
     *
     * @param string $email The email address whose configuration is being retrieved
     * @return array An array containing the email account's configuration details
     * @throws Exception If retrieving the configuration fails
     */
    public function getConfiguration(string $email): array
    {
        // Example API call to retrieve email account configuration
        $data = $this->emailServer->apiCall('GET', '/email/domain/accounts/' . $email);

        // Return the formatted configuration data
        return [
            "account" => $data['account'] ?? 'test@example.com',
            "display" => $data['display'] ?? 'test@example.com',
            "domain" => $data['domain'] ?? 'example.com',
            "inbox_host" => $data['inbox_host'] ?? 'example.com',
            "pop3_port" => $data['pop3_port'] ?? 995,
            "pop3_insecure_port" => $data['pop3_insecure_port'] ?? 110,
            "imap_port" => $data['imap_port'] ?? 993,
            "imap_insecure_port" => $data['imap_insecure_port'] ?? 143,
            "inbox_username" => $data['inbox_username'] ?? 'test@example.com',
            "mail_domain" => $data['mail_domain'] ?? 'example.com',
            "smtp_host" => $data['smtp_host'] ?? 'example.com',
            "smtp_insecure_port" => $data['smtp_insecure_port'] ?? 25,
            "smtp_port" => $data['smtp_port'] ?? 465,
            "smtp_username" => $data['smtp_username'] ?? 'test@example.com',
        ];
    }

    /**
     * Retrieves a Single Sign-On (SSO) URL for accessing webmail for a given email account.
     *
     * @param string $email The email address for which the SSO URL is retrieved
     * @return object{
     *     url: string  // The SSO URL to access the webmail interface
     * }
     * @throws Exception If retrieving the SSO URL fails
     */
    public function webmailSso(string $email): \stdClass
    {
        // Example API call to get webmail SSO URL
        $data = $this->emailServer->apiCall('GET', '/email/domain/' . $this->emailDomain->domain . '/accounts/' . $email . '/webmail');

        $obj = new \stdClass();
        $obj->url = $data['url'];
        return $obj;
    }
}