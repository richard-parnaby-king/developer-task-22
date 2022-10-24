<?php

namespace RichardParnabyKing\DeveloperTask22\Model;

/**
 * JSON Serialisable user model
 * 
 * @method \RichardParnabyKing\DeveloperTask22\Model\User setId(int $value)
 * @method int|NULL getId()
 * @method \RichardParnabyKing\DeveloperTask22\Model\User setEmail(String $value)
 * @method String|NULL getEmail()
 * @method \RichardParnabyKing\DeveloperTask22\Model\User setFirstName(String $value)
 * @method String|NULL getFirstName()
 * @method \RichardParnabyKing\DeveloperTask22\Model\User setLastName(String $value)
 * @method String|NULL getLastName()
 * @method \RichardParnabyKing\DeveloperTask22\Model\User setAvatar(String $value)
 * @method String|NULL getAvatar()
 */
class User implements \JsonSerializable
{
    /**
     * User data
     */
    private $data = [];
    
    /**
     * Magic method to set or get user data.
     * @param String $name
     * @param mixed $arguments
     * @return self
     */
    public function __call($name, $arguments) {
        //Get data, eg ::getName()
        if(strpos($name,'get')===0) {
            $name = substr($name, 3);
            $name = lcfirst($name);
            if(array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }
            return null;
        }
        //Set data, eg ::setName(string)
        if(strpos($name,'set')===0) {
            $name = substr($name, 3);
            $name = lcfirst($name);
            $this->data[$name] = implode(',',$arguments);
        }
        
        return $this;
    }
    
    /**
     * Returns data which can be serialized by json_encode()
     * @return Array
     */
    public function jsonSerialize() {
        return $this->data;
    }
}