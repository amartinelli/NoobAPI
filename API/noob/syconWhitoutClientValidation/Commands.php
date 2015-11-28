<?php
        namespace noob\sycon;
        use Luracast\Restler\RestException;
        use DB_PDO_MySQL;

        class Commands
        {
            public $dp;
            public $tbname = 'Commands';

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
                * @param int $Reference  {@from body}
                * @param string $Code  {@from body}             
             *
             * @return mixed
             */
            function post($Client_ID, $Reference, $Code)
            {
                return $this->dp->insert(compact('Client_ID', 'Reference', 'Code'));
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Reference  {@from body}
                * @param string $Code  {@from body}
             *
             * @return mixed
             */
            function put($id, $Client_ID, $Reference, $Code)
            {
                $r = $this->dp->update($id, compact('Client_ID', 'Reference', 'Code'));
                if ($r === false)
                    throw new RestException(404);
                return $r;
            }

            /**
             * @param int    $id
             *
                * @param int $Client_ID  {@from body}
                * @param int $Reference  {@from body}
                * @param string $Code  {@from body}
             *
             * @return mixed
             */
            function patch($id, $Client_ID = null, $Reference = null, $Code = null)
            {
                $patch = $this->dp->get($id);
                if ($patch === false)
                    throw new RestException(404);
                $modified = false;
                
                    if (isset($Client_ID)) {
                        $patch['Client_ID'] = $Client_ID;
                        $modified = true;
                    }

                
                    if (isset($Reference)) {
                        $patch['Reference'] = $Reference;
                        $modified = true;
                    }

                
                    if (isset($Code)) {
                        $patch['Code'] = $Code;
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

        