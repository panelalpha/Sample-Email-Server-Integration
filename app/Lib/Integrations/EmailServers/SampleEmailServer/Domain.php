<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer;

use App\Lib\Integrations\EmailServers\SampleEmailServer;
use App\Lib\Integrations\EmailServers\AbstractEmailServer\AbstractDomain;
use App\Lib\Interfaces\Integrations\EmailServer\DomainInterface;
use App\Models\EmailDomain;
use Exception;

/**
 * Class Domain
 *
 * Provides functionality for managing domains on an email server.
 *
 * @property EmailDomain{
 *     id: int,
 *     user_id: int,
 *     service_id: int,
 *     server_account_id: int,
 *     domain: string,
 *     details: array
 * } $emailDomain
 */
class Domain extends AbstractDomain implements DomainInterface
{
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
        $result = SampleEmailServer::sampleAPI()->listAccounts($this->emailDomain->domain);

        foreach ($result['accounts'] as $account) {
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
        $result = SampleEmailServer::sampleAPI()->listForwarders($this->emailDomain->domain);

        foreach ($result['forwarders'] as $forwarder) {
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
        // Example API call to check if the domain exists
        $result = SampleEmailServer::sampleAPI()->emailDomainExists($this->emailDomain->domain);
        return $result['exists'];
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
        $result = SampleEmailServer::sampleAPI()->createEmailDomain($this->emailDomain->domain);

        // Update EmailDomain model with new details and save
        $this->emailDomain->setDetails([
            'detail' => $result['details']['detail'],
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
        SampleEmailServer::sampleAPI()->deleteEmailDomain($this->emailDomain->domain);
    }
}
