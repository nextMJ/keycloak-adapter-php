<?php
    /**
     * Created by PhpStorm.
     * User: miroslav
     * Date: 23/04/2019
     * Time: 09:56
     */

    namespace Ataccama\Utils;


    use Nette\SmartObject;


    /**
     * @property-read string   $email
     * @property-read string   $name
     * @property-read string   $id
     * @property-read string   $username
     * @property-read string[] $roles
     * @property-read string[] $groups
     */
    class UserIdentity
    {
        use SmartObject;

        /** @var string[] */
        private $roles, $groups;

        /** @var string */
        protected $email, $name, $id, $username;

        /**
         * UserIdentity constructor.
         * @param \stdClass $userIdentity
         */
        public function __construct(\stdClass $userIdentity)
        {
            $this->id = $userIdentity->sub;
            $this->email = $userIdentity->email ?? 'unknown';
            $this->name = $userIdentity->name ?? 'unknown';
            $this->username = $userIdentity->preferred_username ?? 'unknown';
            $this->roles = $userIdentity->realm_access->roles ? 'unknown';

            if (isset($userIdentity->group)) {
                $this->groups = $userIdentity->group;
                $this->groups = substr_replace($this->groups, '', 0, 1);    // all groups starts with '/' --> remove it
            } else {
                $this->groups = array();
            }
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email ?? "unknown";
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name ?? "unknown";
        }

        /**
         * @return string
         */
        public function getId(): string
        {
            return $this->id ?? "unknown";
        }

        /**
         * @return string
         */
        public function getUsername(): string
        {
            return $this->username ?? "unknown";
        }

        /**
         * @param string $clientId
         * @return string[]
         */
        public function getRoles(string $clientId): array
        {
            return $this->roles;

            /* original code - not suitable for our application

            if (isset($this->roles->{"$clientId"})) {
                $roles = [];
                foreach ($this->roles->{"$clientId"}->roles as $role) {
                    $roles[] = $role;
                }

                return $roles;
            }

            return [];*/
        }

        /**
         * @return string[]
         */
        public function getGroups(): array
        {
            return $this->groups;
        }

    }
