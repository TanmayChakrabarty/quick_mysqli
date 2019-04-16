# quick_mysqli
Class to connect and query MySQL using MySQLi. Inspired by ezSQL

## get_results(query, index_with, result_format)
query is your query string
index_with is the name of the column that will be use as index instead of auto-numeric values
result_format can be AS_RAW, OBJECT, ARRAY_N, ARRAY_A

### using AS_RAW format

 - you should use this format when you don't need to run multiple queries, for example a query that collects the data for a csv report.
 - this is the fastest, no extra loops :)

 #### example 
 ```
$data = $db->get_results( "SELECT * FROM _users", null, AS_RAW);
while ( $row = @$data->fetch_object() ){
    print_r($row);
} 
 ```

though I am fetching as object, you can fetch as any as you want such as fetch_assoc() for associative array or fetch_array() for numeric array indexed

