<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Validates UUID v4 compliance against RFC 4122
 *
 * @see https://www.ietf.org/rfc/rfc4122.txt
 */
class UuidV4Validator extends AbstractValidator
{
    /**
     * @var string UUIDV4
     */
    const UUIDV4 = 'uuidv4';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::UUIDV4 => "'%value%' is not a v4 UUID valid against RFC 4122"
    );

    /**
     * Checks validity of the UUID
     *
     * @param string $value The value to check
     *
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        if (1 !== preg_match('/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89AB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/', $value)) {
            $this->error(self::UUIDV4);
            return false;
        }

        return true;
    }
}
