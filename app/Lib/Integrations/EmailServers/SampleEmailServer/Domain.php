<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer;


use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Integrations\EmailServers\AbstractEmailServer\AbstractDomain;
use App\Lib\Integrations\EmailServers\SampleEmailServer\Domain\Account;
use App\Lib\Integrations\EmailServers\SampleEmailServer\Domain\Forwarder;
use App\Lib\Interfaces\Integrations\EmailServer\DomainInterface;
use App\Models\EmailDomain;
use App\Models\EmailServer;
use Exception;

/**
 * Class Domain
 *
 * Provides functionality for managing domains on an email server.
 * This includes retrieving, creating, and deleting domains, as well as managing
 * email accounts and forwarders associated with a specific domain.
 *
 * This class implements DomainInterface and extends AbstractDomain to align with the
 * generic domain structure used across different email servers.
 */
class Domain extends AbstractDomain implements DomainInterface
{
    /**
     * Constructor for the Domain class.
     *
     * The EmailDomain model has the following attributes:
     * - id (int)               : The unique identifier of the model
     * - user_id (int)          : The unique identifier of the associated user
     * - service_id (int)       : The unique identifier of the associated service
     * - server_account_id (int): The unique identifier of the server account
     * - domain (string)        : The domain name
     * - details (array)        : Additional details about the domain
     *
     * @param SampleEmailServer $sampleEmailServer Instance of the email server being used
     * @param EmailDomain $emailDomain The email domain model instance
     */
    public function __construct(private SampleEmailServer $emailServer, private EmailDomain $emailDomain)
    {
    }

    /**
     * Returns an instance of the Account class for managing email accounts.
     *
     * @return Account Instance of the Account management class
     */
    public function account(): Account
    {
        return new Account($this->emailServer, $this->emailDomain);
    }

    /**
     * Returns an instance of the Forwarder class for managing email forwarders.
     *
     * @return Forwarder Instance of the Forwarder management class
     */
    public function forwarder(): Forwarder
    {
        return new Forwarder($this->emailServer, $this->emailDomain);
    }

    /**
     * Retrieves a list of all email accounts for the given domain.
     *
     * The response contains the disk usage and quota for each account.
     * - disk_usage (int): Disk usage in MB
     * - disk_quota (int|null): Disk quota, or null if no limit is set
     *
     * @return array[] List of email accounts, where each account includes:
     *                 - 'email' (string) The email address
     *                 - 'disk_usage' (int) Disk usage in MB
     *                 - 'disk_quota' (int|null) Disk quota, or null if no limit
     */
    public function listAccounts(): array
    {
        $accounts = [];

        // Example API call to get list of email accounts for the domain
        $data = $this->emailServer->apiCall('GET', '/email/accounts', [
            'domain' => $this->emailDomain->domain,
        ]);

        // Process each account from the API response
        foreach ($data['accounts'] as $account) {
            $accounts[] = [
                'email' => $account['email'],
                'disk_usage' => $account['disk_usage'],
                'disk_quota' => $account['disk_quota'] ?? null,
            ];
        }

        return $accounts;
    }

    /**
     * Retrieves a list of all email forwarders for the given domain.
     *
     * @return array[] List of email forwarders, where each forwarder includes:
     *                 - 'email' (string) The email address being forwarded
     *                 - 'forward_to' (string) The email address to which it is forwarded
     */
    public function listForwarders(): array
    {
        $forwarders = [];

        // Example API call to get list of email forwarders for the domain
        $data = $this->emailServer->apiCall('GET', '/email/forwarders', [
            'domain' => $this->emailDomain->domain,
        ]);

        // Process each forwarder from the API response
        foreach ($data['forwarders'] as $forwarder) {
            $forwarders[] = [
                'email' => $forwarder['email'],
                'forward_to' => $forwarder['forward_to'],
            ];
        }

        return $forwarders;
    }

    /**
     * Checks if the domain exists on the email server.
     *
     * @return bool True if the domain exists, false otherwise
     */
    public function exists(): bool
    {
        try {
            // Example API call to check if the domain exists
            $response = $this->emailServer->apiCall('GET', '/email/domain-exists', [
                'domain' => $this->emailDomain->domain,
            ]);

            return isset($response['exists']) ? $response['exists'] : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Creates a new domain on the email server.
     *
     * Updates the EmailDomain model with the new details after successful creation.
     *
     * @throws Exception If the domain creation fails
     */
    public function create(): void
    {
        // Example API call to create a new domain
        $data = $this->emailServer->apiCall('POST', '/email/create-domain', [
            'domain' => $this->emailDomain->domain,
        ]);


        // Update EmailDomain model with new details and save
        $this->emailDomain->setDetails([
            'detail' => $data['detail'],
        ]);
        $this->emailDomain->save();

    }

    /**
     * Deletes the domain from the email server.
     *
     * @throws Exception If the domain deletion fails
     */
    public function delete(): void
    {
        // Example API call to delete the domain
        $this->emailServer->apiCall('DELETE', '/email/delete-domain', [
            'domain' => $this->emailDomain->domain,
        ]);
    }
}