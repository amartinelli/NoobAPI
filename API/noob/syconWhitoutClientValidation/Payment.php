<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Payment
        {
            public $dp;
            public $tbname = 'Payment';

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
                * @param int $Payment_Type_ID  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Payment_Type_ID)
            {
                return $this->dp->insert(compact('Client_ID', 'Payment_Type_ID'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Payment_Type_ID  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Payment_Type_ID)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Payment_Type_ID'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Payment_Type_ID  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Payment_Type_ID = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Payment_Type_ID)) {
                        $patch['Payment_Type_ID'] = $Payment_Type_ID;
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

        