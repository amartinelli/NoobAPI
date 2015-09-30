<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Product
        {
            public $dp;
            public $tbname = 'Product';

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
             * @param int $Lot_ID  {@from body}
            * @param varchar $Name  {@from body}
            * @param int $Category  {@from body}
            * @param int $Measure_ID  {@from body}
            * @param varchar $Quantity  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Lot_ID''Name','Category','Measure_ID','Quantity',));
            }

            /**
             * @param int    $id
             * @param int $Lot_ID  {@from body}
            * @param varchar $Name  {@from body}
            * @param int $Category  {@from body}
            * @param int $Measure_ID  {@from body}
            * @param varchar $Quantity  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Lot_ID''Name','Category','Measure_ID','Quantity',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Lot_ID  {@from body}
            * @param varchar $Name  {@from body}
            * @param int $Category  {@from body}
            * @param int $Measure_ID  {@from body}
            * @param varchar $Quantity  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Lot_ID = null, $Name = null, $Category = null, $Measure_ID = null, $Quantity = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Lot_ID)) {
                        $patch['Lot_ID'] = $Lot_ID;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Category)) {
                        $patch['Category'] = $Category;
                        $modified = true;
                    }

                
                    if (isset($Measure_ID)) {
                        $patch['Measure_ID'] = $Measure_ID;
                        $modified = true;
                    }

                
                    if (isset($Quantity)) {
                        $patch['Quantity'] = $Quantity;
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

        