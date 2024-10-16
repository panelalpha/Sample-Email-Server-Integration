<?php

namespace App\Lib\Integrations\EmailServers;

use App\Lib\Integrations\EmailServers\AbstractEmailServer;
use App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;
use App\Lib\Interfaces\Integrations\ExternalEmailServerInterface;
use App\Models\EmailDomain;
use App\Models\EmailServer;
use Exception;

/**
 * Class SampleEmailServer
 *
 * Provides a sample implementation of an email server integration.
 * The class contains methods to manage email domains, test connection to the
 * email server API, and retrieve usage statistics.
 *
 * This class extends AbstractEmailServer and implements ExternalEmailServerInterface.
 */
class SampleEmailServer extends AbstractEmailServer implements ExternalEmailServerInterface
{
    /**
     * The name of the email server.
     *
     * @var string
     */
    public static string $name = "Sample Email Server";

    /**
     * The unique slug used to identify this email server in the system.
     *
     * @var string
     */
    public static string $slug = "sample-email-server";

    /**
     * Indicates whether this email server integration is enabled or not.
     *
     * @var bool|null
     */
    public static ?bool $enabled = true;

    /**
     * Configuration fields needed to connect to the email server API.
     *
     * Each configuration field consists of:
     * - 'name' (string) - the field identifier
     * - 'type' (string) - the field type, e.g., text or checkbox
     *
     * Example email server requires: api_url, api_key, ssl_verification
     *
     * @var array
     */
    public static array $configFields = [
        'api_url' => [
            'name' => 'api_url',
            'type' => 'text',
        ],
        'api_key' => [
            'name' => 'api_key',
            'type' => 'text',
        ],
        'ssl_verification' => [
            'name' => 'ssl_verification',
            'type' => 'checkbox',
        ],
    ];

    /**
     * Optional configuration fields needed to create an email domain.
     *
     * Each field consists of:
     * - 'name' (string) - the field identifier
     * - 'type' (string) - the field type, e.g., text or checkbox
     *
     * If field needs data from email server,
     * it can be retrieved in getAvailableServerValues() method.
     *
     * Example email server requires to create email domain 'example_config'
     *
     * @var array
     */
    public static array $accountConfigFields = [
        'example_config' => [
            'name' => 'example_config',
            'type' => 'text',
            'default' => 'Default',
        ],
    ];

    /**
     * The model instance for the email server.
     *
     * EmailServer object contains:
     * - id (int) - the model identifier
     * - name (string) - the name of the email server
     * - type (string) - the type of email server
     * - connection_config (array) - API connection details based on $configFields
     * - details (array) - additional details such as IP address
     *
     * @var EmailServer
     */
    public EmailServer $model;

    /**
     * Constructor to initialize the email server instance.
     *
     * @param EmailServer $emailServer The email server model instance.
     */
    public function __construct(EmailServer $emailServer)
    {
        $this->model = $emailServer;
    }

    /**
     * Returns a Domain object for managing a specific email domain.
     *
     * @param EmailDomain $emailDomain The email domain model instance.
     * @return Domain Instance of the Domain class associated with the email domain.
     */
    public function domain(EmailDomain $emailDomain): Domain
    {
        return new Domain($this, $emailDomain);
    }

    /**
     * Tests the connection to the email server API using the provided configuration.
     *
     * Example $config array:
     * - api_url (string)
     * - api_key (string)
     * - ssl_verification (bool)
     *
     * @param array $config The API connection configuration based on $configFields.
     * @return void
     * @throws Exception If the connection test fails.
     */
    public static function testConnection(array $config): void
    {
        // Example API call to test the connection to the email server.
        // Replace with actual API call logic.
    }

    /**
     * Retrieves a list of all email domains from the email server.
     *
     * Each domain in the list includes:
     * - 'domain' (string) The domain name
     * - 'details' (array) Additional details about the domain
     *
     * @return array[] List of email domains.
     */
    public function listDomains(): array
    {
        $domains = [];

        // Example API call to retrieve a list of email domains.
        $data = $this->apiCall('GET', '/email/domains');

        // Process and format the domains.
        foreach ($data['domains'] as $domain) {
            $domains[] = [
                'domain' => $domain['name'],
                'details' => [
                    'remote_id' => $domain['id'],
                ],
            ];
        }

        return $domains;
    }

    /**
     * Retrieves details for a specific email domain by its name.
     *
     * @param string $domain The email domain name.
     * @return ?array{
     *     domain: string,
     *     details: array,
     * } The domain details, or null if not found.
     */
    public function findDomain(string $domain): ?array
    {
        // Example API call to retrieve a single domain by its name.
        $data = $this->apiCall('GET', "/email/domains/{$domain}");

        if (!$data || !isset($data['domain'])) {
            return null;
        }

        return [
            'domain' => $data['domain']['name'],
            'details' => [
                'remote_id' => $data['domain']['id'],
            ],
        ];
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
        /**
         * To get list of email domain under service you can use
         * $this->service->emailDomains->pluck('domain');
         * which will create an array of domain names, e.g.
         *   $domains = [
         *     'example.com,
         *     'example.org,
         *   ]
         */
        $domains = $this->service->emailDomains->pluck('domain');

        // Example API call to get usage statistics for email accounts and forwarders.
        $data = $this->apiCall('GET', '/email/usage', $domains);

        return [
            'email_accounts' => [
                'usage' => $data['email_accounts']['usage'],
                'maximum' => $data['email_accounts']['maximum'] ?? null,
            ],
            'forwarders' => [
                'usage' => $data['forwarders']['usage'],
                'maximum' => $data['forwarders']['maximum'] ?? null,
            ],
        ];
    }

    /**
     * Retrieves available configuration values for account setup.
     *
     * Optional method that fetches dynamic values for fields defined in
     * $accountConfigFields. This is useful for fields with multiple possible values.
     *
     * Example:
     * For the 'example_config' field, this method retrieves all possible configurations.
     *
     * The method returns an array with 'text' and 'value' keys for each available option.
     *
     * @return array List of available configuration values for the email server.
     */
    public function getAvailableServerValues(): array
    {
        // Example API call to retrieve available configuration values for the server.
        $data = $this->apiCall('GET', '/email/config-values');

        $exampleConfig = [];
        foreach ($data['example_config'] as $item) {
            $exampleConfig[] = [
                'text' => $item['name'],
                'value' => $item['id'],
            ];
        }

        return [
            'example_config' => $exampleConfig,
        ];
    }
}