<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

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
             *
                * @param int $Client_ID  {@from body}
                * @param int $Provider_ID  {@from body}
                * @param int $Code  {@from body}
                * @param date $Date  {@from body}
                * @param date $Manufacture  {@from body}
                * @param date $Maturity  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Provider_ID, $Code, $Date, $Manufacture, $Maturity)
            {
                return $this->dp->insert(compact('Client_ID', 'Provider_ID', 'Code', 'Date', 'Manufacture', 'Maturity'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Provider_ID  {@from body}
                * @param int $Code  {@from body}
                * @param date $Date  {@from body}
                * @param date $Manufacture  {@from body}
                * @param date $Maturity  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Provider_ID, $Code, $Date, $Manufacture, $Maturity)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Provider_ID', 'Code', 'Date', 'Manufacture', 'Maturity'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Provider_ID  {@from body}
                * @param int $Code  {@from body}
                * @param date $Date  {@from body}
                * @param date $Manufacture  {@from body}
                * @param date $Maturity  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Provider_ID = null, $Code = null, $Date = null, $Manufacture = null, $Maturity = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
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

        