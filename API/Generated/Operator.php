<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

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
             * @status 201
             *
             * @param varchar $Name  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Login  {@from body}
            * @param varchar $Password  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Name''Phone','CPhone','Email','Login','Password',));
            }

            /**
             * @param int    $id
             * @param varchar $Name  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Login  {@from body}
            * @param varchar $Password  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Name''Phone','CPhone','Email','Login','Password',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param varchar $Name  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Login  {@from body}
            * @param varchar $Password  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Name = null, $Phone = null, $CPhone = null, $Email = null, $Login = null, $Password = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
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

        