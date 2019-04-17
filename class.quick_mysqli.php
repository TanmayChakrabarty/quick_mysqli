<?php 
if ( ! function_exists ('mysqli_connect') ) die('<b>Fatal Error:</b> quick_mysqli requires mySQLi Lib to be compiled and or linked in to the PHP engine');

defined('QUICK_MYSQLI_VERSION') or define('QUICK_MYSQLI_VERSION', '1.0');
defined('AS_RAW') or define('AS_RAW', 'AS_RAW');
defined('OBJECT') or define('OBJECT', 'OBJECT');
defined('ARRAY_A') or define('ARRAY_A', 'ARRAY_A');
defined('ARRAY_N') or define('ARRAY_N', 'ARRAY_N');

class Quick_Mysqli
{
    var $dbuser = false;
    var $dbpassword = false;
    var $dbname = false;
    var $dbhost = false;
    var $dbport = false;
    var $encoding = false;
    var $dbh = null;
    var $rows_affected = false;
    var $all_queries = array();
    var $num_queries = 0;
    var $result = null;

    function __construct( $dbuser='', $dbpassword='', $dbname='', $dbhost='localhost', $encoding='utf8', $dbport=3306 ) 
    {
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->dbport = $dbport;
        $this->encoding = $encoding;
    }

    function connect( ) 
    {
        $return_val = false;

        $this->dbh = new mysqli( $this->dbhost, $this->dbuser, $this->dbpassword, '', $this->dbport );
 
        if( $this->dbh->connect_error ) {
            trigger_error( 'MySQLi Connection error in '.__FILE__.' on line '.__LINE__, E_USER_ERROR ) ;
        } else {
            $return_val = true;
            $this->conn_queries = 0;
        }

        return $return_val;
    }

    function select( ) {
        $return_val = false;

        if ( !$this->dbh ) {
            trigger_error( 'You are trying to select a DB without having an active connection'.' in '.__FILE__.' on line '.__LINE__, E_USER_ERROR );
        } else if ( !@$this->dbh->select_db($this->dbname) ) {
            // Try to get error supplied by mysql if not use our own
            if ( !$str = @$this->dbh->error ) $str = 'Unexpected error while trying to select a DB';
            trigger_error( $str.' in '.__FILE__.' on line '.__LINE__, E_USER_ERROR );
        } else {
            if( $this->encoding ) {
                $encoding = strtolower( str_replace( "-", "", $this->encoding ) );
                $charsets = array();
                $result = $this->dbh->query( "SHOW CHARACTER SET" );
                while( $row = $result->fetch_array( MYSQLI_ASSOC ) ) {
                    $charsets[] = $row["Charset"];
                }
                if( in_array( $encoding, $charsets ) ) {
                    $this->dbh->set_charset( $encoding );
                }
            }
            
            $return_val = true;
        }
        return $return_val;
    }

    function escape( $str ) {
        if ( ! isset($this->dbh) || ! $this->dbh ) {
            return false;
        } 
                    
        if ( get_magic_quotes_gpc() ) {
            $str = stripslashes( $str );
        }                        

        return $this->dbh->escape_string( $str );
    }

    function deep_escape( $value ){
        if( is_array( $value ) ){
            foreach( $value as $i=>$v ){
                if( is_array( $v ) ) $value[$i] = $this->deep_escape( $v );
                else $value[$i] = $this->escape( $v );
                }
            }
        else $value = $this->escape( $value );
        
        return $value;
    }

    function query( $query ) {
        if ( $this->num_queries >= 500 ) {
            $this->disconnect();
            $connected = $this->connect();
            if( $connected ) {
                $selected = $this->select();
                if( !$selected ) {
                    return false;
                }
            } else {
                return false;
            }
        }

        $return_val = 0;

        $query = trim( $query );

        $this->all_queries[] = $query;

        $this->num_queries++;
        
        if ( !isset($this->dbh) || !$this->dbh ) {
            $connected = $this->connect();
            if( $connected ) {
                $selected = $this->select();
                if( !$selected ) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if( is_object( @$this->result ) ) @$this->result->free_result();
        $this->result = @$this->dbh->query( $query );

        if ( $str = @$this->dbh->error ) {
            trigger_error( $str, E_USER_WARNING );
            return false;
        }
        
        if ( !is_object($this->result) ) { // Query was a Data Manipulation Query (insert, delete, update, replace, ...)
            $this->rows_affected = @$this->dbh->affected_rows;

            if ( preg_match( "/^(insert|replace)\s+/i", $query ) ) {
                $this->insert_id = @$this->dbh->insert_id;
                $return_val = $this->insert_id;
            }
            else
                $return_val = $this->rows_affected;
        } else { // Query was a Data Query Query (select, show, ...)
            $return_val = $this->result->num_rows;
        }

        return $return_val;
    }

    function disconnect( ) {
        $this->conn_queries = 0;
        @$this->dbh->close();
    }

    function get_row( $query, $format = OBJECT) {
        if ( $query ){
            $this->query( $query );
            }

        if( $format == AS_RAW ) {
            trigger_error( 'get_row() method does not support format AS_RAW in Quick_Mysqli', E_USER_ERROR );
        } else if ( $format == OBJECT ) {
            $result = null;
            while ( $row = @$this->result->fetch_object() ) {
                $result = $row;
                break;
            }

            @$this->result->free_result();
            return $result;
        } else if ( $format == ARRAY_A ) {
            $result = null;
            while ( $row = @$this->result->fetch_assoc() ) {
                $result = $row;
            }

            @$this->result->free_result();
            return $result;
        } else {
            $result = null;
            while ( $row = @$this->result->fetch_array( MYSQLI_NUM ) ) {
                $result = $row;   
            }
            @$this->result->free_result();
            return $result;
        }
    }

    function get_results( $query, $index_with = null, $format = OBJECT) {
        if ( $query ){
            $this->query( $query );
            }

        // Send back array of objects. Each row is an object
        if( $format == AS_RAW ) {
            return $this->result;
        } else if ( $format == OBJECT ) {
            $result = array();
            while ( $row = @$this->result->fetch_object() ) {
                if( $index_with ) {
                    $result[$row->$index_with] = $row;
                } else {
                    $result[] = $row;
                }
            }

            @$this->result->free_result();
            return $result;
        } else if ( $format == ARRAY_A ) {
            $result = array();
            while ( $row = @$this->result->fetch_assoc() ) {
                if($index_with) {
                    $result[$row[$index_with]] = $row;
                } else {
                    $result[] = $row;
                }
            }

            @$this->result->free_result();
            return $result;
        } else {
            $result = array();
            if( $index_with ) {
                $index_num = null;
                while( $col = $this->result->fetch_field() ) {
                    $index_num = is_null( $index_num ) ? 0 : ++$index_num;
                    if( $col->name == $index_with ) {
                        break;
                    }
                }
            }
            while ( $row = @$this->result->fetch_array( MYSQLI_NUM ) ) {
                if( $index_with ) {
                    $result[$row[$index_num]] = $row;
                } else {
                    $result[] = $row;
                }
                
            }
            @$this->result->free_result();
            return $result;
        }
    }
}