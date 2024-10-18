<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer;

use App\Lib\Integrations\EmailServers\AbstractEmailServer\AbstractDomain;
use App\Lib\Interfaces\Integrations\EmailServer\DomainInterface;

/**
 * Class Domain
 *
 * Provides functionality for managing domains on an email server.
 *
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
        $domainName = $this->model()->domain;

        // Example API call to get list of email accounts for the domain
        $result = $this->emailServer()->sampleAPI()->listAccounts($domainName);

        return [
            [
                'email' => 'test@example.com',
                'disk_usage' => 12,
                'disk_quota' => 512,
            ],
            [
                'email' => 'john@example.com',
                'disk_usage' => 43,
                'disk_quota' => 1000,
            ],
        ];
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
        $domainName = $this->model()->domain;

        // Example API call to get list of email forwarders for the domain
        $result = $this->emailServer()->sampleAPI()->listForwarders($domainName);

        return [
            [
                'email' => 'test@example.com',
                'forward_to' => 'john@example.net',
            ],
            [
                'email' => 'john@example.com',
                'forward_to' => 'test@example.net',
            ]
        ];
    }

    /**
     * Checks if the domain exists on the email server.
     *
     * @return bool True if the domain exists, false otherwise
     */
    public function exists(): bool
    {
        $domainName = $this->model()->domain;

        // Example API call to check if the domain exists
        $result = $this->emailServer()->sampleAPI()->emailDomainExists($domainName);

        return false;
    }

    /**
     * Creates a new domain on the email server.
     *
     * Updates the EmailDomain model with the new details after successful creation.
     *
     * @throws \Exception If the domain creation fails
     */
    public function create(): void
    {
        $domainName = $this->model()->domain;

        // Example API call to create a new domain
        $result = $this->emailServer()->sampleAPI()->createEmailDomain($domainName);

        // Update model with new details and save
        $this->model()->setDetails([
            'remote_id' => 12,
        ]);
        $this->model()->save();
    }

    /**
     * Deletes the domain from the email server.
     *
     * @throws \Exception If the domain deletion fails
     */
    public function delete(): void
    {
        $domainName = $this->model()->domain;

        // Example API call to delete the domain
        $this->emailServer()->sampleAPI()->deleteEmailDomain($domainName);
    }

    /**
     * Retrieves usage statistics for email accounts and forwarders on the server.
     *
     * The response includes:
     * - 'email_accounts' (array) The usage and maximum limits for email accounts.
     * - 'forwarders' (array) The usage and maximum limits for forwarders.
     *
     *  Possible values:
     *  - usage - only integer
     *  - maximum - integer or null for no limit
     *
     * @return array The usage details for email accounts and forwarders.
     */
    public function usage(): array
    {
        $domain = $this->model();
        $domainDetails = $domain->getDetails();

        $domainName = $domain->domain;
        $domainId = $domainDetails['remote_id'];

        $result = $this->emailServer()->sampleAPI()->getDomainByName($domainName);
        $result = $this->emailServer()->sampleAPI()->getDomainById($domainId);

        return [
            'email_accounts' => [
                'usage' => 4,
                'maximum' => 100,
            ],
            'forwarders' => [
                'usage' => 3,
                'maximum' => null,
            ],
        ];
    }
}
