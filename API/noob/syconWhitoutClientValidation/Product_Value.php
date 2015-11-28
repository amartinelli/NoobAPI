<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Product_Value
        {
            public $dp;
            public $tbname = 'Product_Value';

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
                * @param int $Product_ID  {@from body}
                * @param int $Client_ID  {@from body}
                * @param string $Value  {@from body}
                * @param date $Date  {@from body}             
             *
             * @return mixed
             */
            function post($Product_ID, $Client_ID, $Value, $Date)
            {
                return $this->dp->insert(compact('Product_ID', 'Client_ID', 'Value', 'Date'));
            }

            /**
             * @param int    $id
             *
                * @param int $Product_ID  {@from body}
                * @param int $Client_ID  {@from body}
                * @param string $Value  {@from body}
                * @param date $Date  {@from body}
             *
             * @return mixed
             */
            function put($id, $Product_ID, $Client_ID, $Value, $Date)
            {
                $r = $this->dp->update($id, compact('Product_ID', 'Client_ID', 'Value', 'Date'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Product_ID  {@from body}
                * @param int $Client_ID  {@from body}
                * @param string $Value  {@from body}
                * @param date $Date  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Product_ID = null, $Client_ID = null, $Value = null, $Date = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Product_ID)) {
                        $patch['Product_ID'] = $Product_ID;
                        $modified = true;
                    }

                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Value)) {
                        $patch['Value'] = $Value;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
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

        