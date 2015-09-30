<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Command_Product
        {
            public $dp;
            public $tbname = 'Command_Product';

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
                * @param int $Commands_ID  {@from body}
                * @param int $Sale_ID  {@from body}
                * @param int $Product_ID  {@from body}
                * @param date $Date  {@from body}
                * @param string $Quantity  {@from body}
                * @param string $Flag  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Commands_ID, $Sale_ID, $Product_ID, $Date, $Quantity, $Flag)
            {
                return $this->dp->insert(compact('Client_ID', 'Commands_ID', 'Sale_ID', 'Product_ID', 'Date', 'Quantity', 'Flag'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Commands_ID  {@from body}
                * @param int $Sale_ID  {@from body}
                * @param int $Product_ID  {@from body}
                * @param date $Date  {@from body}
                * @param string $Quantity  {@from body}
                * @param string $Flag  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Commands_ID, $Sale_ID, $Product_ID, $Date, $Quantity, $Flag)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Commands_ID', 'Sale_ID', 'Product_ID', 'Date', 'Quantity', 'Flag'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Commands_ID  {@from body}
                * @param int $Sale_ID  {@from body}
                * @param int $Product_ID  {@from body}
                * @param date $Date  {@from body}
                * @param string $Quantity  {@from body}
                * @param string $Flag  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Commands_ID = null, $Sale_ID = null, $Product_ID = null, $Date = null, $Quantity = null, $Flag = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Commands_ID)) {
                        $patch['Commands_ID'] = $Commands_ID;
                        $modified = true;
                    }

                
                    if (isset($Sale_ID)) {
                        $patch['Sale_ID'] = $Sale_ID;
                        $modified = true;
                    }

                
                    if (isset($Product_ID)) {
                        $patch['Product_ID'] = $Product_ID;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
                        $modified = true;
                    }

                
                    if (isset($Quantity)) {
                        $patch['Quantity'] = $Quantity;
                        $modified = true;
                    }

                
                    if (isset($Flag)) {
                        $patch['Flag'] = $Flag;
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

        