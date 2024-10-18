<?php

namespace App\Lib\Integrations\EmailServers\SampleEmailServer\Domain;

use App\Lib\Integrations\EmailServers\AbstractEmailServer\Domain\AbstractForwarder;
use App\Lib\Interfaces\Integrations\EmailServer\Domain\ForwarderInterface;

/**
 * Class Forwarder
 *
 * This class handles the creation and deletion of email forwarders associated with
 * a domain on an email server.
 */
class Forwarder extends AbstractForwarder implements ForwarderInterface
{
    /**
     * Creates a new email forwarder for the given domain.
     *
     * Parameters:
     * - email (string)      : The email address from which the emails are forwarded
     * - domain (string)     : The domain of the email address
     * - destination (string): The destination email address to which emails are forwarded
     *
     * @param array $params An array containing 'email', 'domain', and 'destination'
     * @return void
     */
    public function create(array $params): void
    {
        $domainName = $this->emailDomain()->domain;

        // Example API call to create a new forwarder
        $this->emailServer()->sampleAPI()->createForwarder($domainName, $params);
    }

    /**
     * Deletes an existing email forwarder for the given domain.
     *
     * Parameters:
     * - email (string)      : The email address from which the emails are forwarded
     * - forward_to (string) : The destination email address to which emails are forwarded
     *
     * @param string $email The email address that is being forwarded
     * @param string $forward_to The destination email address for the forwarder
     * @return void
     */
    public function delete(string $email, string $forward_to): void
    {
        $domainName = $this->emailDomain()->domain;

        // Example API call to delete an existing forwarder
        $this->emailServer()->sampleAPI()->createForwarder($domainName, $email, $forward_to);
    }
}
