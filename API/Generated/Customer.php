<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;
        //use DB_Session;

        class Customer
        {
            public $dp;
            public $tbname = 'Customer';

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
             * @param int $Category  {@from body}
            * @param int $Points  {@from body}
            * @param varchar $Name  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param int $Client_ID  {@from body}
                         
             *
             * @return mixed
             */
            function post($Name, $Phone)
            {
                return $this->dp->insert(compact('Category''Points','Name','Email','Phone','CPhone','Client_ID',));
            }

            /**
             * @param int    $id
             * @param int $Category  {@from body}
            * @param int $Points  {@from body}
            * @param varchar $Name  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param int $Client_ID  {@from body}
            
             *
             * @return mixed
             */
            function put($id, $Name, $Phone)
            {
                $r = $this->dp->update($id, compact('Category''Points','Name','Email','Phone','CPhone','Client_ID',));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             * @param int $Category  {@from body}
            * @param int $Points  {@from body}
            * @param varchar $Name  {@from body}
            * @param varchar $Email  {@from body}
            * @param varchar $Phone  {@from body}
            * @param varchar $CPhone  {@from body}
            * @param int $Client_ID  {@from body}
            
             *
             * @return mixed
             */
            function patch($id, , $Category = null, $Points = null, $Name = null, $Email = null, $Phone = null, $CPhone = null, $Client_ID = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Category)) {
                        $patch['Category'] = $Category;
                        $modified = true;
                    }

                
                    if (isset($Points)) {
                        $patch['Points'] = $Points;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Email)) {
                        $patch['Email'] = $Email;
                        $modified = true;
                    }

                
                    if (isset($Phone)) {
                        $patch['Phone'] = $Phone;
                        $modified = true;
                    }

                
                    if (isset($CPhone)) {
                        $patch['CPhone'] = $CPhone;
                        $modified = true;
                    }

                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
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

        