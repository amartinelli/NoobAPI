<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Lot
        {
            public $dp;
            public $tbname = 'Lot';

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
             * @param int $Provider_ID  {@from body}
            * @param int $Code  {@from body}
            * @param datetime $Date  {@from body}
            * @param datetime $Manufacture  {@from body}
            * @param datetime $Maturity  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Provider_ID''Code','Date','Manufacture','Maturity',));
            }

            /**
             * @param int    $id
             * @param int $Provider_ID  {@from body}
            * @param int $Code  {@from body}
            * @param datetime $Date  {@from body}
            * @param datetime $Manufacture  {@from body}
            * @param datetime $Maturity  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Provider_ID''Code','Date','Manufacture','Maturity',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Provider_ID  {@from body}
            * @param int $Code  {@from body}
            * @param datetime $Date  {@from body}
            * @param datetime $Manufacture  {@from body}
            * @param datetime $Maturity  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Provider_ID = null, $Code = null, $Date = null, $Manufacture = null, $Maturity = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Provider_ID)) {
                        $patch['Provider_ID'] = $Provider_ID;
                        $modified = true;
                    }

                
                    if (isset($Code)) {
                        $patch['Code'] = $Code;
                        $modified = true;
                    }

                
                    if (isset($Date)) {
                        $patch['Date'] = $Date;
                        $modified = true;
                    }

                
                    if (isset($Manufacture)) {
                        $patch['Manufacture'] = $Manufacture;
                        $modified = true;
                    }

                
                    if (isset($Maturity)) {
                        $patch['Maturity'] = $Maturity;
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

        