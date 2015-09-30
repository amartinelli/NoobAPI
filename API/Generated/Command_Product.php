<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

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
             * @param int $Commands_ID  {@from body}
            * @param int $Sale_ID  {@from body}
            * @param int $Product_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Quantity  {@from body}
            * @param varchar $Flag  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Commands_ID''Sale_ID','Product_ID','Date','Quantity','Flag',));
            }

            /**
             * @param int    $id
             * @param int $Commands_ID  {@from body}
            * @param int $Sale_ID  {@from body}
            * @param int $Product_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Quantity  {@from body}
            * @param varchar $Flag  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Commands_ID''Sale_ID','Product_ID','Date','Quantity','Flag',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Commands_ID  {@from body}
            * @param int $Sale_ID  {@from body}
            * @param int $Product_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Quantity  {@from body}
            * @param varchar $Flag  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Commands_ID = null, $Sale_ID = null, $Product_ID = null, $Date = null, $Quantity = null, $Flag = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
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

        