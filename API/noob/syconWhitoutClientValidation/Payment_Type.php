<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Payment_Type
        {
            public $dp;
            public $tbname = 'Payment_Type';

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
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Name)
            {
                return $this->dp->insert(compact('Client_ID', 'Name'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Name)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Name'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Name = null)
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

        