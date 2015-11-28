<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Provider
        {
            public $dp;
            public $tbname = 'Provider';

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
                * @param string $Name  {@from body}
                * @param string $Site  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Address  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Name, $Site, $Phone, $CPhone, $Address)
            {
                return $this->dp->insert(compact('Client_ID', 'Name', 'Site', 'Phone', 'CPhone', 'Address'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
                * @param string $Site  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Address  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Name, $Site, $Phone, $CPhone, $Address)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Name', 'Site', 'Phone', 'CPhone', 'Address'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param string $Name  {@from body}
                * @param string $Site  {@from body}
                * @param string $Phone  {@from body}
                * @param string $CPhone  {@from body}
                * @param string $Address  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Name = null, $Site = null, $Phone = null, $CPhone = null, $Address = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Name)) {
                        $patch['Name'] = $Name;
                        $modified = true;
                    }

                
                    if (isset($Site)) {
                        $patch['Site'] = $Site;
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

                
                    if (isset($Address)) {
                        $patch['Address'] = $Address;
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

        