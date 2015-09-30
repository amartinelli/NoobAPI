<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Client
        {
            public $dp;
            public $tbname = 'Client';

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
             * @param varchar $Phone  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Phone'));
            }

            /**
             * @param int    $id
             * @param varchar $Phone  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Phone'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param varchar $Phone  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Phone = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Phone)) {
                        $patch['Phone'] = $Phone;
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

        