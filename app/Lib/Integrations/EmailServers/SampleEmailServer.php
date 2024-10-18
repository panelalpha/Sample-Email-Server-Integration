<?php

namespace App\Lib\Integrations\EmailServers;

use App\Lib\Integrations\EmailServers\AbstractEmailServer;
use App\Lib\Interfaces\Integrations\ExternalEmailServerInterface;

/**
 * Class SampleEmailServer
 *
 * Provides a sample implementation of an email server integration.
 * The class contains methods to manage email domains, test connection to the
 * email server API, and retrieve usage statistics.
 *
 */
class SampleEmailServer extends AbstractEmailServer implements ExternalEmailServerInterface
{
    /**
     * The name of the email server.
     */
    public static string $name = "Sample Email Server";

    /**
     * The unique slug used to identify this email server in the system.
     */
    public static string $slug = "sample-email-server";

    /**
     * The URL to the email server's official website.
     *
     * This link shows up in email server list in admin area.
     * For informational purposes only.
     *
     * Optional.
     */
    public static ?string $link = "https://example.com";

    /**
     * Configuration fields needed to connect to the email server API.
     *
     * Each configuration field consists of:
     * - 'name' (string) - the field identifier
     * - 'type' (string) - the field type, e.g., text or checkbox
     *
     * Form with these fields will be rendered in admin area when adding/editing email server.
     *
     * If the email server is configured in admin area, values of these fields can be accessed
     * by using `$this->getConnectionConfig()` from within this class
     *
     * @var array<array> $configFields
     */
    public static array $configFields = [
        'api_url' => [
            'name' => 'api_url',
            'label' => 'API URL',
            'type' => 'text',
        ],
        'api_key' => [
            'name' => 'api_key',
            'label' => 'API Key',
            'type' => 'text',
        ],
        'ssl_verification' => [
            'name' => 'ssl_verification',
            'label' => 'SSL Verification',
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
     * Form with these fields will be rendered in admin area when adding/editing plan.
     *
     * If the plan is configured in admin area, values of these fields can be accessed
     * by using `$this->getPlanConfig()` from Domain/Account/Forwarder classes within this namespace.
     *
     * @var array<array> $configFields
     */
    public static array $accountConfigFields = [
        'email_plan' => [
            'name' => 'email_plan',
            'label' => 'Email Plan',
            'type' => 'text',
            'default' => 'unlimited',
        ],
    ];

    /**
     * Tests the connection to the email server API using the provided configuration.
     * This method doesn't expect return on success and should throw exception on failure.
     *
     * @param array $config The API connection configuration based on $configFields.
     * @return void
     * @throws \Exception If the connection test fails.
     */
    public static function testConnection(array $config): void
    {
        // Example API call to test the connection to the email server.

        $result = self::sampleAPI()->testConnection([
            'api_url' => $config['api_url'],
            'api_key' => $config['api_key'],
            'ssl_verification' => $config['ssl_verification'] ?? false,
        ]);
        if ($result['error']) {
            throw new \Exception($result['error']);
        }
    }

    /**
     * Retrieves a list of all email domains from the email server.
     * Used in email server synchronization.
     *
     * Returned value is expected to be an array of arrays containing:
     * - 'domain' (string) The domain name
     * - 'details' (array) Additional details about the domain
     *
     * @return array<array{
     *   domain: string,
     *   details?: array<string,mixed>
     * }>
     */
    public function listDomains(): array
    {
        $config = $this->getConnectionConfig();

        $this->sampleAPI()->authorize([
            'api_url' => $config['api_url'],
            'api_key' => $config['api_key'],
            'ssl_verification' => $config['ssl_verification'] ?? null,
        ]);

        // Example API call to retrieve a list of email domains.
        $result = $this->sampleAPI()->getDomains();

        $domains = [];
        foreach ($result as $domain) {
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
     * Used in email server synchronization.
     *
     * Returns the domains array, or null if not found.
     *
     * @param string $domain The email domain name.
     * @return ?array{
     *     domain: string,
     *     details: array,
     * }
     */
    public function findDomain(string $domain): ?array
    {
        // Example API call to retrieve a single domain by its name.
        $result = $this->sampleAPI()->findDomain($domain);

        if (!$result) {
            return null;
        }

        return [
            'domain' => $result['domain']['name'],
            'details' => [
                'remote_id' => $result['domain']['id'],
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
     * For the 'email_plan' field, this method retrieves all possible configurations.
     * This will replace text input with dropdown when adding/editing plan in admin area.
     *
     * The method returns an array with 'text' and 'value' keys for each available option.
     *
     */
    public function getAvailableServerValues(): array
    {
        // Example API call to retrieve available configuration values for the server.
        $result = $this->sampleAPI()->getPlans();

        $plans = [];
        foreach ($result as $plan) {
            $plans[] = [
                'text' => $plan['name'],
                'value' => $plan['id'],
            ];
        }

        return [
            'email_plan' => $plans,
        ];
    }

    /**
     * This method simulates API responses from email server.
     * Used for demonstration purposes only.
     */
    public static function sampleAPI(): object
    {
        return (new class () {
            public function __call(string $name, array $arguments)
            {
                return true;
            }

            public function testConnection($config)
            {
                sleep(1);
                return [
                    "data" => "OK",
                    "error" => rand(0, 1) == 1 ? "Sometimes I work, sometimes I don't" : null,
                ];
            }

            public function getDomains()
            {
                return [
                    ['id' => 1, 'name' => 'example.com'],
                    ['id' => 3, 'name' => 'example.org'],
                ];
            }

            public function findDomain(string $domain)
            {
                return [
                    'id' => 1,
                    'name' => 'example.com',
                    'details' => [
                        'remote_id' => '123'
                    ]
                ];
            }

            public function getPlans()
            {
                return [
                    ['id' => 'starter', 'name' => 'Starter'],
                    ['id' => 'premium', 'name' => 'Premium'],
                    ['id' => 'unlimited', 'name' => 'Unlimited'],
                ];
            }
        });
    }
}
