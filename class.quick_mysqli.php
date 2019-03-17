<? 
if ( ! function_exists ('mysqli_connect') ) die('<b>Fatal Error:</b> quick_mysqli requires mySQLi Lib to be compiled and or linked in to the PHP engine');

defined('QUICK_MYSQLI_VERSION') or define('QUICK_MYSQLI_VERSION', '1.0');
defined('OBJECT') or define('OBJECT', 'OBJECT');
defined('ARRAY_A') or define('ARRAY_A', 'ARRAY_A');
defined('ARRAY_N') or define('ARRAY_N', 'ARRAY_N');

class quick_mysqli{
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

    function __construct( $dbuser='', $dbpassword='', $dbname='', $dbhost='localhost', $encoding='utf8', $dbport=3306 ) {
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->dbport = $dbport;
        $this->encoding = $encoding;
    }

    function connect( ) {
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

			$this->result = @$this->dbh->query( $query );

			if ( $str = @$this->dbh->error ) {
				trigger_error( $str, E_USER_WARNING );
				return false;
			}

			// Query was a Data Manipulation Query (insert, delete, update, replace, ...)
			if ( !is_object($this->result) )
			{
				$is_insert = true;
				$this->rows_affected = @$this->dbh->affected_rows;

				// Take note of the insert_id
				if ( preg_match("/^(insert|replace)\s+/i",$query) )
				{
					$this->insert_id = @$this->dbh->insert_id;
				}

				// Return number fo rows affected
				$return_val = $this->rows_affected;
			}
			// Query was a Data Query Query (select, show, ...)
			else
			{
				$is_insert = false;

				// Take note of column info
				$i=0;
				while ($i < @$this->result->field_count)
				{
					$this->col_info[$i] = @$this->result->fetch_field();
					$i++;
				}

				// Store Query Results
				$num_rows=0;
				while ( $row = @$this->result->fetch_object() )
				{
					// Store relults as an objects within main array
					$this->last_result[$num_rows] = $row;
					$num_rows++;
				}

				@$this->result->free_result();

				// Log number of rows the query returned
				$this->num_rows = $num_rows;

				// Return number of rows selected
				$return_val = $this->num_rows;
			}

			// disk caching of queries
			$this->store_cache($query,$is_insert);

			// If debug ALL queries
			$this->trace || $this->debug_all ? $this->debug() : null ;

			// Keep tack of how long all queries have taken
			$this->timer_update_global($this->num_queries);

			// Trace all queries
			if ( $this->use_trace_log )
			{
				$this->trace_log[] = $this->debug(false);
			}

			return $return_val;

		}

    function disconnect( ) {
        $this->conn_queries = 0;
        @$this->dbh->close();
    }
}