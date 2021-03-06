<?php

/**
 * Copyright 2014 SURFnet bv
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Surfnet\SamlBundle\SAML2\Attribute;

use Surfnet\SamlBundle\Exception\InvalidArgumentException;
use Surfnet\SamlBundle\Exception\LogicException;

class AttributeDefinition
{
    const MULTIPLICITY_SINGLE   = 1;
    const MULTIPLICITY_MULTIPLE = 2;

    /**
     * @var string the name of the saml attribute
     */
    private $name;

    /**
     * @var int the multiplicity of this attribute
     */
    private $multiplicity;

    /**
     * @var string the urn:mace identifier of this attribute
     */
    private $urnMace;

    /**
     * @var string the urn:oid identifier of this attribute
     */
    private $urnOid;

    /**
     * @param string $name
     * @param string $urnMace
     * @param string $urnOid
     * @param int    $multiplicity
     */
    public function __construct($name, $urnMace = null, $urnOid = null, $multiplicity = self::MULTIPLICITY_SINGLE)
    {
        if (!is_string($name)) {
            throw InvalidArgumentException::invalidType('string', 'name', $name);
        }

        if (!is_null($urnMace) && !is_string($urnMace)) {
            throw InvalidArgumentException::invalidType('null or string', 'urnMace', $urnMace);
        }

        if (!is_null($urnOid) && !is_string($urnOid)) {
            throw InvalidArgumentException::invalidType('null or string', 'urnOid', $urnOid);
        }

        if (is_null($urnOid) && is_null($urnMace)) {
            throw new LogicException('An AttributeDefinition should have at least either a mace or an oid urn');
        }

        if (!in_array($multiplicity, [self::MULTIPLICITY_SINGLE, self::MULTIPLICITY_MULTIPLE])) {
            throw new InvalidArgumentException(sprintf(
                'Multiplicity should be once of "%s", "%s" given',
                implode('", "', [self::MULTIPLICITY_SINGLE, self::MULTIPLICITY_MULTIPLE]),
                $multiplicity
            ));
        }

        $this->name         = $name;
        $this->multiplicity = $multiplicity;
        $this->urnMace      = $urnMace;
        $this->urnOid       = $urnOid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function hasUrnMace()
    {
        return $this->urnMace !== null;
    }

    /**
     * @return string
     */
    public function getUrnMace()
    {
        return $this->urnMace;
    }

    /**
     * @return string
     */
    public function hasUrnOid()
    {
        return $this->urnOid !== null;
    }

    /**
     * @return string
     */
    public function getUrnOid()
    {
        return $this->urnOid;
    }

    /**
     * @return int
     */
    public function getMultiplicity()
    {
        return $this->multiplicity;
    }

    /**
     * @param AttributeDefinition $other
     * @return bool
     */
    public function equals(AttributeDefinition $other)
    {
        return $this->name === $other->name
            && $this->urnOid === $other->urnOid
            && $this->urnMace === $other->urnMace
            && $this->multiplicity === $other->multiplicity;
    }
}
