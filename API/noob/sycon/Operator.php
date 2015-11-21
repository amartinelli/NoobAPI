<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Operator
        {
            public $dp;
            public $tbname = 'Operator';

            function __construct()
            {
                $tbname = $this->tbname;
                $this->dp = new DB_PDO_MySQL($tbname);
            }

            function index()
            {
                return $this->dp->getAll();
            }

            /**
             * @param int $id
             *
             * @return array
             */
            function get($id)
            {
                $r = $this->dp->get($id);
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @access private
             *
             * @param string $Email {@from body}
             * @param string $Password {@from body}
             *
             * @return array
             */
            function postLogin($Email, $Password)
            {
                $Password = hash('sha256', $Password);
                $r = $this->dp->login($Email,$Password);
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @status 201
             *
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Email  {@from body}
                * @param string $Login  {@from body}
                * @param string $Password  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Name, $Phone, $CPhone, $Email, $Login, $Password)
            {
                return $this->dp->insert(compact('Client_ID', 'Name', 'Phone', 'CPhone', 'Email', 'Login', 'Password'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Email  {@from body}
                * @param string $Login  {@from body}
                * @param string $Password  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Name, $Phone, $CPhone, $Email, $Login, $Password)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Name', 'Phone', 'CPhone', 'Email', 'Login', 'Password'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Email  {@from body}
                * @param string $Login  {@from body}
                * @param string $Password  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Name = null, $Phone = null, $CPhone = null, $Email = null, $Login = null, $Password = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Phone)) {
                        $patch['Phone'] = $Phone;
                        $modified = true;
                    }

                
                    if (isset($CPhone)) {
                        $patch['CPhone'] = $CPhone;
                        $modified = true;
                    }

                
                    if (isset($Email)) {
                        $patch['Email'] = $Email;
                        $modified = true;
                    }

                
                    if (isset($Login)) {
                        $patch['Login'] = $Login;
                        $modified = true;
                    }

                
                    if (isset($Password)) {
                        $patch['Password'] = $Password;
                        $modified = true;
                    }

                
                if (!$modified) {
                    throw new RestException(304); //not modified
                }
                $r = $this->dp->update($id, $patch);
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int $id
             *
             * @return array
             */
            function delete($id)
            {
                return $this->dp->delete($id);
            }
        }

        