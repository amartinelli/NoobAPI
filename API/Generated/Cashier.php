<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Cashier
        {
            public $dp;
            public $tbname = 'Cashier';

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
             * @param int $Operator_ID  {@from body}
            * @param datetime $Date_Start  {@from body}
            * @param datetime $Date_End  {@from body}
            * @param varchar $Value_Start  {@from body}
            * @param varchar $Value_End  {@from body}
            * @param varchar $Ref  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Operator_ID''Date_Start','Date_End','Value_Start','Value_End','Ref',));
            }

            /**
             * @param int    $id
             * @param int $Operator_ID  {@from body}
            * @param datetime $Date_Start  {@from body}
            * @param datetime $Date_End  {@from body}
            * @param varchar $Value_Start  {@from body}
            * @param varchar $Value_End  {@from body}
            * @param varchar $Ref  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Operator_ID''Date_Start','Date_End','Value_Start','Value_End','Ref',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Operator_ID  {@from body}
            * @param datetime $Date_Start  {@from body}
            * @param datetime $Date_End  {@from body}
            * @param varchar $Value_Start  {@from body}
            * @param varchar $Value_End  {@from body}
            * @param varchar $Ref  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Operator_ID = null, $Date_Start = null, $Date_End = null, $Value_Start = null, $Value_End = null, $Ref = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Operator_ID)) {
                        $patch['Operator_ID'] = $Operator_ID;
                        $modified = true;
                    }

                
                    if (isset($Date_Start)) {
                        $patch['Date_Start'] = $Date_Start;
                        $modified = true;
                    }

                
                    if (isset($Date_End)) {
                        $patch['Date_End'] = $Date_End;
                        $modified = true;
                    }

                
                    if (isset($Value_Start)) {
                        $patch['Value_Start'] = $Value_Start;
                        $modified = true;
                    }

                
                    if (isset($Value_End)) {
                        $patch['Value_End'] = $Value_End;
                        $modified = true;
                    }

                
                    if (isset($Ref)) {
                        $patch['Ref'] = $Ref;
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

        