<?php

namespace App\Lib\Integrations\EmailServers\Cpanel;

use App\Lib\Integrations\EmailServers\AbstractEmailServer\AbstractDomain;
use App\Lib\Integrations\EmailServers\Cpanel\Domain\Account;
use App\Lib\Integrations\EmailServers\Cpanel\Domain\Forwarder;
use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Interfaces\Integrations\EmailServer\DomainInterface;
use App\Models\EmailDomain;
use Exception;

class Domain extends AbstractDomain implements DomainInterface
{
    /**
     * Constructor for the Domain class.
     *
     * @param App\Lib\Integrations\EmailServers\EmailServer $emailServer Instance of Cpanel class for API communication
     * @param App\Models\EmailDomain $emailDomain Email domain model
     */
    public function __construct(public SampleEmailServer $emailServer, public EmailDomain $emailDomain)
    {
    }

    /**
     * Returns an instance of the Account class for managing email accounts.
     *
     * @return App\Lib\Integrations\EmailServers\EmailServer\Domain\Account
     */
    public function account(): App\Lib\Integrations\EmailServers\EmailServer\Domain\Account
    {
        return new App\Lib\Integrations\EmailServers\EmailServer\Domain\Account($this->emailServer, $this->emailDomain);
    }

    /**
     * Returns an instance of the Forwarder class for managing email forwarders.
     *
     * @return App\Lib\Integrations\EmailServers\EmailServer\Domain\Forwarder
 */
    public function forwarder(): App\Lib\Integrations\EmailServers\EmailServer\Domain\Forwarder
    {
        return new App\Lib\Integrations\EmailServers\EmailServer\Domain\Forwarder($this->emailServer, $this->emailDomain);
    }

    /**
     * Retrieves a list of all email accounts for the given domain.
     *
     * @return array List of email accounts with disk usage and quota information
     * @throws Exception In case of API communication error
     */
    public function listAccounts(): array
    {
        // Call API to get the list of email accounts assigned to email domain
        // Process the received data and return it in the appropriate format

        // Sample return data:
        return [
            [
                'email' => 'john@example.com',
                'disk_usage' => 50, // in MB
                'disk_quota' => null // unlimited
            ],
            [
                'email' => 'jane@example.com',
                'disk_usage' => 75, // in MB
                'disk_quota' => 2000 // in MB
            ]
        ];
    }

    /**
     * Retrieves a list of all email forwarders for the given domain.
     *
     * @return array List of email forwarders
     * @throws Exception In case of API communication error
     */
    public function listForwarders(): array
    {
        // Call API to get the list of forwarders assigned to email Domain
        // Process the received data and return it in the appropriate format

        // Sample return data:
        return [
            [
                'email' => 'sales@example.com',
                'forward_to' => 'john@example.com'
            ],
            [
                'email' => 'support@example.com',
                'forward_to' => 'jane@example.com'
            ]
        ];
    }

    /**
     * Checks if the domain exists in the cPanel system.
     *
     * @return bool True if the domain exists, false otherwise
     * @throws Exception In case of API communication error
     */
    public function exists(): bool
    {
        // Call API to check domain existence
        // Interpret the response and return the appropriate boolean value


        // Sample implementation:
        $domainExists = true; // This would be the result of the API call
        return $domainExists;
    }

    /**
     * Creates a new domain in the cPanel system.
     *
     * @throws Exception In case of an error during domain creation
     */
    public function create(): void
    {
        // Call cPanel API to create a new account
        // Update the EmailDomain model with new data


    }

    /**
     * Deletes the domain from the cPanel system.
     *
     * @throws Exception In case of an error during domain deletion
     */
    public function delete(): void
    {
        // Call cPanel API to delete the domain account
    }
}