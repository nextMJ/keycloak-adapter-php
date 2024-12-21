<?php
    /**
     * Created by PhpStorm.
     * User: miroslav
     * Date: 14/05/2019
     * Time: 10:38
     */

    namespace Ataccama\Adapters\Utils;


    use Nette\SmartObject;
    use Ataccama\Utils\AccessToken;


    /**
     * Class UserProfile
     * @package Ataccama\Adapters\Utils
     * @property-read string   $id
     * @property-read string   $name
     * @property-read string   $email
     * @property-read string   $refreshToken
     * @property-read int      $refreshTokenExpiration
     * @property-read string[] $roles
     * @property-read string   $username
     */
    class UserProfile
    {
        use SmartObject;

        /** @var string */
        protected $id, $name, $email, $refreshToken, $username;

        /** @var string[] */
        protected $roles, $groups;

        /** @var int */
        protected $refreshTokenExpiration;

        /** @var AccessToken */
        protected $accessToken;

        /**
         * UserProfile constructor.
         * @param string   $id
         * @param string   $name
         * @param string   $email
         * @param AccessToken $accessToken
         * @param string   $refreshToken
         * @param int      $refreshTokenExpiration
         * @param string[] $roles
         */
        public function __construct(
            string $id,
            string $name,
            string $email,
            AccessToken $accessToken,
            string $refreshToken,
            int $refreshTokenExpiration,
            array $roles,
            array $groups,
            string $username
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->accessToken = $accessToken;
            $this->refreshToken = $refreshToken;
            $this->refreshTokenExpiration = $refreshTokenExpiration;
            $this->roles = $roles;
            $this->groups = $groups;
            $this->username = $username;
        }

        /**
         * @return string
         */
        public function getUsername(): string
        {
            return $this->username;
        }

        /**
         * @return string
         */
        public function getId(): string
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * @return AccessToken
         */
        public function getAccessToken(): AccessToken
        {
            return $this->accessToken;
        }

        /**
         * @return string
         */
        public function getRefreshToken(): string
        {
            return $this->refreshToken;
        }

        /**
         * @return int
         */
        public function getRefreshTokenExpiration(): int
        {
            return $this->refreshTokenExpiration;
        }

        /**
         * @return string[]
         */
        public function getRoles(): array
        {
            return $this->roles;
        }

        /**
         * @return string[]
         */
        public function getGroups(): array
        {
            return $this->groups;
        }
    }