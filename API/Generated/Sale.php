<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Sale
        {
            public $dp;
            public $tbname = 'Sale';

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
            * @param int $Payment_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Value  {@from body}
            * @param int $Operator_ID  {@from body}
            * @param int $Cashier_ID  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Commands_ID''Payment_ID','Date','Value','Operator_ID','Cashier_ID',));
            }

            /**
             * @param int    $id
             * @param int $Commands_ID  {@from body}
            * @param int $Payment_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Value  {@from body}
            * @param int $Operator_ID  {@from body}
            * @param int $Cashier_ID  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Commands_ID''Payment_ID','Date','Value','Operator_ID','Cashier_ID',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Commands_ID  {@from body}
            * @param int $Payment_ID  {@from body}
            * @param datetime $Date  {@from body}
            * @param varchar $Value  {@from body}
            * @param int $Operator_ID  {@from body}
            * @param int $Cashier_ID  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Commands_ID = null, $Payment_ID = null, $Date = null, $Value = null, $Operator_ID = null, $Cashier_ID = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Commands_ID)) {
                        $patch['Commands_ID'] = $Commands_ID;
                        $modified = true;
                    }

                
                    if (isset($Payment_ID)) {
                        $patch['Payment_ID'] = $Payment_ID;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
                        $modified = true;
                    }

                
                    if (isset($Value)) {
                        $patch['Value'] = $Value;
                        $modified = true;
                    }

                
                    if (isset($Operator_ID)) {
                        $patch['Operator_ID'] = $Operator_ID;
                        $modified = true;
                    }

                
                    if (isset($Cashier_ID)) {
                        $patch['Cashier_ID'] = $Cashier_ID;
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

        