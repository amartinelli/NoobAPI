<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class History
        {
            public $dp;
            public $tbname = 'History';

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
             * @param int $Sale_ID  {@from body}
            * @param int $Customer_ID  {@from body}
            * @param longtext $Register_Json  {@from body}
            * @param varchar $Total  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Sale_ID''Customer_ID','Register_Json','Total',));
            }

            /**
             * @param int    $id
             * @param int $Sale_ID  {@from body}
            * @param int $Customer_ID  {@from body}
            * @param longtext $Register_Json  {@from body}
            * @param varchar $Total  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Sale_ID''Customer_ID','Register_Json','Total',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Sale_ID  {@from body}
            * @param int $Customer_ID  {@from body}
            * @param longtext $Register_Json  {@from body}
            * @param varchar $Total  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Sale_ID = null, $Customer_ID = null, $Register_Json = null, $Total = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Sale_ID)) {
                        $patch['Sale_ID'] = $Sale_ID;
                        $modified = true;
                    }

                
                    if (isset($Customer_ID)) {
                        $patch['Customer_ID'] = $Customer_ID;
                        $modified = true;
                    }

                
                    if (isset($Register_Json)) {
                        $patch['Register_Json'] = $Register_Json;
                        $modified = true;
                    }

                
                    if (isset($Total)) {
                        $patch['Total'] = $Total;
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

        